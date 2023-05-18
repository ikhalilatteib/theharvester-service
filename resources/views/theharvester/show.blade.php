@extends(config('theharvester-service.layouts'))
@section('style')
	
	<style>
        .terminal {
            display: flex;
            flex-direction: column;
            height: 300px;
            padding: 10px;
            background-color: #000;
            color: #fff;
            font-family: monospace;
            font-size: 14px;
        }

        .terminal-output {
            flex: 1;
            overflow-y: scroll;
            padding-right: 20px;
        }
	</style>
@endsection
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
			@foreach($theharvester->containers as $chart)
				<div  @class([
    							"p-0",
    							"col-md-3" => $theharvester->containers->count()>=4,
    							"col-md-4" => $theharvester->containers->count()==3,
    							"col-md-6" => $theharvester->containers->count()==2,
    							"col-md-12" => $theharvester->containers->count()==1,
				])>
					<div class="card mt-2 border-0">
						<div class="card-header text-black text-center">Konteyner {{$loop->iteration}}</div>
						<div class="card-body p-0">
							<div id="chartdiv_{{$chart->id}}" style="height:250px;"></div>
						</div>
					</div>
				</div>
			@endforeach
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
@section('script')
	
	<script src="{{asset('assets/plugins/amcharts5/index.js')}}"></script>
	<script src="{{asset('assets/plugins/amcharts5/xy.js')}}"></script>
	<script src="{{asset('assets/plugins/amcharts5/themes/Animated.js')}}"></script>
	@foreach($theharvester->containers as $conJs)
		<script>
            am5.ready(function () {


                var root = am5.Root.new("chartdiv_{{$conJs->id}}");

                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true
                }));


                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineY.set("visible", false);


                var xRenderer = am5xy.AxisRendererX.new(root, {minGridDistance: 30});
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                });

                xRenderer.grid.template.setAll({
                    location: 1
                })

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "country",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                    })
                }));


                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series 1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "value",
                    sequencedInterpolation: true,
                    categoryXField: "country",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                }));

                series.columns.template.setAll({cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0});
                series.columns.template.adapters.add("fill", function (fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function (stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                var data = [{
                    country: "IP",
                    value: {{$conJs->ip}}
                }, {
                    country: "Host",
                    value: {{$conJs->host}}
                }, {
                    country: "Email",
                    value: {{$conJs->email}}
                }, {
                    country: "Süre (s)",
                    value: {{$conJs->operation_time}}
                }];


                xAxis.data.setAll(data);
                series.data.setAll(data);

                series.appear(1000);
                chart.appear(1000, 100);

            }); // end am5.ready()
		</script>
	@endforeach

@endsection