@extends('layout.app')
@section('content')

<section class="page__title p-relative d-flex align-items-center fix" data-background="{{ asset('assets/img/page-title/page-title-1.jpg') }}">
	<div class="slider__shape">
		<img class="shape triangle" src="{{ asset('assets/img/icon/slider/triangle.png') }}" alt="triangle">
		<img class="shape dotted-square" src="{{ asset('assets/img/icon/slider/dotted-square.png') }}" alt="dotted-square">
		<img class="shape solid-square" src="{{ asset('assets/img/icon/slider/solid-square.png') }}" alt="solid-square">
		<img class="shape circle-2" src="{{ asset('assets/img/icon/slider/circle.png') }}" alt="circle">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="page__title-content mt-100">
					<h2>{{ $pageTitle }}</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item active text-light" aria-current="page">{{ $pageTitle }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about__area py-4 bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-5">
				<div class="m-img wow fadeInLeft" data-wow-delay=".2s">
					<img src="{{ asset('assets/img/profile/1.svg') }}" alt="">
				</div>
			</div>

			<div class="col-md-8 col-lg-6">
				<div class="d-flex h-100">
					<form method="POST" action="{{ route('user.profile') }}" class="w-100 my-auto">
						@csrf

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-left">Name</label>

							<div class="col-md-8">
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

								@error('name')
								<span class="invalid-feedback text-left">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-left">Email</label>

							<div class="col-md-8">
								<input id="email" type="email" class="form-control" value="{{ Auth::user()->email }}" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label for="mobile_number" class="col-md-4 col-form-label text-left">Mobile Number</label>

							<div class="col-md-8">
								<input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ Auth::user()->mobile_number }}" required autocomplete="mobile_number" autofocus>

								@error('mobile_number')
								<span class="invalid-feedback text-left">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group pt-4 justify-content-between">
							<button type="submit" class="btn btn-primary float-right text-light">Update Profile</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>
@stop