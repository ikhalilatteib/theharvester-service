@extends(config('theharvester-service.layouts'))
@section('breadcrumb')
	<div class="breadcrumbbar">
		<div class="row align-items-center">
			<div class="col-md-8 col-lg-8">
				<div class="media">
					<span class="breadcrumb-icon"><i class="ri-terminal-line"></i></span>
					<div class="media-body">
						<h4 class="page-title">Yeni Theharvester</h4>
						<div class="breadcrumb-list">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ config('theharvester-service.dashboard')}}">MC</a></li>
								<li class="breadcrumb-item"><a href="javascript:void(0);">Görevler</a></li>
								<li class="breadcrumb-item"><a href="{{route('tasks.theharvesters.index')}}">Theharvester</a></li>
								<li class="breadcrumb-item active" aria-current="page">Yeni Theharvester</li>
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
				<div class="card">
					<div class="card-header">Yeni Theharvester Oluştur
					</div>
					
					<div class="card-body">
						<form action="{{ route('tasks.theharvesters.store') }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="title">Başlık</label>
								<input type="text" name="title" id="title"
								       class="form-control @error('title') is-invalid @enderror"
								       value="{{ old('title') }}" required>
								@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							
							<div class="form-group">
								<label for="description">Tanım</label>
								<textarea type="text" name="description" id="description" rows="4"
								          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
								@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group">
								<label for="domain">Domain</label>
								<input type="text" id="domain" name="domain" class="form-control @error('ip') is-invalid @enderror" value="{{old('domain')}}" />
								@error('domain')
								<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							
							<div class="form-group">
								<label for="container">Konteyner Sayısı</label>
								<input type="number" name="container" id="container" max="10" min="1"
								       class="form-control @error('container') is-invalid @enderror"
								       value="{{ old('container',1) }}" required>
								@error('container')
								<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block">Oluştur</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

