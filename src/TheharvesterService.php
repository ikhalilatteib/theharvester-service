<?php

namespace Ikay\TheharvesterService;

use GuzzleHttp\Client;
use Ikay\TheharvesterService\Models\Theharvester;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TheharvesterService
{
    protected $client;

    private $logger;

    public function __construct(public Theharvester $theharvester)
    {
        $this->logger = Log::channel('single');

        try {
            $this->client = new Client([
                'base_uri' => config('services.docker.endpoint'),
                'timeout' => config('services.docker.timeout'),
            ]);
        } catch (\Exception $e) {
            $this->saveEventualErrors($e);
            $this->logger->error($e->getMessage());
        }

    }

    protected function saveEventualErrors($e): void
    {
        $this->theharvester->update(['status' => 2]);

        $this->theharvester->errorLogs()->create([
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    public function createTheharvesterContainer()
    {
        $this->theharvester->containers()->delete();

        try {
            $sources = config('theharvester-service.sources');
            $containerCount = $this->theharvester->container;
            $sourcesPerContainer = ceil(count($sources) / $containerCount);

            for ($i = 0; $i < $containerCount; $i++) {
                $start = $i * $sourcesPerContainer;
                $end = ($i + 1) * $sourcesPerContainer;
                $sourcesChunk = array_slice($sources, $start, $sourcesPerContainer);

                $response = $this->client->post('/containers/create', [
                    'json' => [
                        'Image' => 'secsi/theharvester:latest',
                        'Cmd' => ['-d', $this->theharvester->domain, '-b', implode(',', $sourcesChunk)],
                    ],
                ]);

                $container = json_decode((string) $response->getBody(), true);

                // Start the container
                $this->logger->info('Started container with ID: '.$container['Id']);
                $this->startContainer($container['Id']);

                $this->stopContainer($container['Id']);

                $operation_time = $this->containerRunTime($container['Id']);

                $logs = $this->getContainerLogs($container['Id']);

                $parsedLogs = $this->parseContainerLogs($logs);

                $this->storeContainerLogs($parsedLogs, $container['Id'], $operation_time);
            }
            $this->theharvester->update(['status' => 1]);

            $this->logger->info('container is created');
        } catch (\Exception $e) {
            $this->saveEventualErrors($e);
            $this->logger->error($e->getMessage());
        }
    }

    protected function startContainer(string $containerId)
    {
        try {
            if (empty($containerId)) {
                throw new \InvalidArgumentException('Invalid container ID');
            }

            $this->client->post('/containers/'.$containerId.'/start');

        } catch (\Exception $e) {
            $this->saveEventualErrors($e, $this->theharvester);
            $this->logger->error($e->getMessage());
        }
    }

    protected function stopContainer(string $containerId)
    {
        try {
            if (empty($containerId)) {
                throw new \InvalidArgumentException('Invalid container ID');
            }

            $this->client->post('/containers/'.$containerId.'/stop?t=60');

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    protected function containerRunTime($containerID)
    {
        try {
            $response = $this->client->get('/containers/'.$containerID.'/json');

            $container = json_decode((string) $response->getBody(), true);

            $start = Carbon::create($container['State']['StartedAt']);

            return Carbon::create($container['State']['FinishedAt'])->diffInSeconds($start);
        } catch (\Exception $e) {
            $this->saveEventualErrors($e, $this->theharvester);
            $this->logger->error($e->getMessage());
        }
    }

    protected function getContainerLogs(string $containerId): string
    {
        try {
            // Stream the container logs (include both stdout and stderr)
            $response = $this->client->get('/containers/'.$containerId.'/logs?stdout=1&stderr=1&follow=1');
            $stream = $response->getBody();

            // Read the logs until the stream is closed
            $logs = '';
            while (! $stream->eof()) {
                $logs .= $stream->read(1024);
            }

            return $logs;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return '';
        }
    }

    protected function parseContainerLogs(string $log): array
    {
        $log = preg_replace('/[^[:alnum:][:space:][:punct:]]/', '', $log);
        // Initialize data array with default values
        $data = [
            'ip' => 0,
            'email' => 0,
            'host' => 0,
            'log' => $log,
        ];

        // Define regular expression pattern to match IP, email, and host counts
        $pattern = '/\[\*\]\s*(IPs|Emails|Hosts) found:\s*(\d+)/i';

        // Execute regular expression and update data array accordingly
        if (preg_match_all($pattern, $log, $matches)) {
            foreach ($matches[1] as $i => $type) {
                $count = (int) $matches[2][$i];
                switch (strtolower($type)) {
                    case 'ips':
                        $data['ip'] = $count;
                        break;
                    case 'emails':
                        $data['email'] = $count;
                        break;
                    case 'hosts':
                        $data['host'] = $count;
                        break;
                }
            }
        }

        return $data;
    }

    protected function storeContainerLogs(array $logs, string $containerId, $operation_time): void
    {
        try {

            $logs['operation_time'] = $operation_time;
            $logs['container_id'] = $containerId;
            $this->theharvester->containers()->create($logs);

        } catch (\Exception $e) {
            $this->saveEventualErrors($e, $this->theharvester);
            $this->logger->error($e->getMessage());
        }

    }
}
