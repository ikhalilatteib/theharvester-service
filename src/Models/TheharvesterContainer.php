<?php

namespace Ikay\TheharvesterService\Models;

use Illuminate\Database\Eloquent\Model;

class TheharvesterContainer extends Model
{
    protected $table = 'theharvester_containers';

    protected $fillable = [
        'container_id',
        'theharvester_id',
        'domain',
        'source',
        'ip',
        'email',
        'host',
        'log',
        'operation_time',
    ];
}
