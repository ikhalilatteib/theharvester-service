@extends(config('theharvester-service.layouts'))
@section('breadcrumb')
	<div class="breadcrumbbar">
		<div class="row align-items-center">
			<div class="col-md-8 col-lg-8">
				<div class="media">
					<span class="breadcrumb-icon"><i class="ri-terminal-line"></i></span>
					<div class="media-body">
						<h4 class="page-title">Detay</h4>
						<div class="breadcrumb-list">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{config('theharvester-service.dashboard')}}">MC</a></li>
								<li class="breadcrumb-item"><a href="javascript:void(0);">Görevler</a></li>
								<li class="breadcrumb-item"><a href="{{ route('tasks.theharvesters.index') }}">TheHarvester</a></li>
								<li class="breadcrumb-item active" aria-current="page">Detay</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
				</div>
			</div>
		</div>
	</div>
@endsection
@section('content')
	<div class="contentbar">
		<div class="row">
			<div class="col-md-12">
				<div class="card m-t-30">
					<div class="card-header bg-primary text-white">Detay</div>
					<div class="card-body">
						<h5 class="card-title">{{$theharvester->title}}</h5>
						<p class="card-text">Container Sayısı : {{$theharvester->container}}</p>
						<p class="card-text">Oluşturan : {{$theharvester->user->name}}</p>
						<p class="card-text">IP : {{$theharvester->domain}}</p>
						<p class="card-text">Durum
							: {!! \App\Enums\TaskStatusEnum::from($theharvester->status)->taskStatusBadge() !!}</p>
						<p class="card-text">Olusturma Tarihi : {{$theharvester->created_at->format('d.m.Y H:i')}}</p>
						<hr>
						<p class="card-text"><strong>Description:</strong></p>
						<p class="card-text">{{$theharvester->description}}</p>
					</div>
				</div>
				
				<div class="card m-t-30">
					<div class="card-header bg-primary text-white">Konteynerler</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
								<tr>
									<th>#</th>
									<th>Konteyner ID</th>
									<th>Sources</th>
									<th>Hosts</th>
									<th>IPs</th>
									<th>Email</th>
									<th>Süre (s)</th>
									<th>Tarih</th>
									<th class="text-center">Çıktı</th>
								</tr>
								</thead>
								<tbody>
								@foreach($theharvester->containers as $container)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ Str::limit($container->container_id,20) }}</td>
										<td>{{ $container->source }}</td>
										<td>{{ $container->host }}</td>
										<td>{{ $container->ip }}</td>
										<td>{{ $container->email }}</td>
										<td>{{ $container->operation_time }}</td>
										<td>{{ $container->created_at->format('d/m/Y H:i') }}</td>
										<td class="text-center">
											<button data-toggle="modal" data-target="#exampleModal_{{$loop->iteration}}"
											        class="btn btn-primary-rgba btn-sm"><i class="ri-eye-line"></i>
											</button>
										</td>
									</tr>
									<div class="modal fade" id="exampleModal_{{$loop->iteration}}" tabindex="-1"
									     aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg">
											<div class="modal-content bg-dark text-light">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Konteyner
														Çıktisi</h5>
													<button type="button" class="close" data-dismiss="modal"
													        aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="terminal">
														<div class="terminal-output">
															<p>{!!  \App\Helpers\CommandOutputHelper::trimCommandOutput($container->log)!!}</p>
														</div>
													</div>
												
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger"
													        data-dismiss="modal">Kapat
													</button>
												</div>
											</div>
										</div>
									</div>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="card m-t-30">
					<div class="card-header bg-primary text-white">Hatalar</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
								<tr>
									<th>#</th>
									<th>Hata Kodu</th>
									<th>Mesaji</th>
									<th>Satir</th>
									<th>Tarihi (ms)</th>
									<th class="text-center">Detay</th>
								</tr>
								</thead>
								<tbody>
								@forelse($theharvester->errorLogs as $log)
									<tr>
										<td>{{ $loop->iteration }}</td>
										
										<td>{{ $log->code }}</td>
										<td>{{ Str::limit($log->message,80) }}</td>
										<td>{{ $log->line }}</td>
										<td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
										<td class="text-center">
											<button data-toggle="modal" data-target="#exampleLogModal_{{$loop->iteration}}"
											        class="btn btn-primary-rgba btn-sm"><i class="ri-eye-line"></i>
											</button>
										</td>
									</tr>
									<div class="modal fade" id="exampleLogModal_{{$loop->iteration}}" tabindex="-1"
									     aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg">
											<div class="modal-content bg-dark text-light">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Konteyner
														Çıktisi</h5>
													<button type="button" class="close" data-dismiss="modal"
													        aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="terminal">
														<div class="terminal-output">
															<p>{!!  $log->message !!}</p>
														</div>
													</div>
												
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger"
													        data-dismiss="modal">Kapat
													</button>
												</div>
											</div>
										</div>
									</div>
								@empty
									<tr>
										<th colspan="6" class="text-center font-20"> Bu Görev Çalışma Esnasında herhangi bir hata oluşmamıştır</th>
									</tr>
								@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
