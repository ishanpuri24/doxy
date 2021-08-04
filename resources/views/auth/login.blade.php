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
					<h2>{{ $pageTitle ?? 'Login' }}</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item active text-light" aria-current="page">{{ $pageTitle ?? 'Login' }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="contact__help p-relative pb-5 mt-neg-5">
	<div class="contact__shape">
		<img class="dot" src="{{ asset('assets/img/icon/contact/dot.png') }}" alt="">
		<img class="shape" src="{{ asset('assets/img/icon/contact/shape.png') }}" alt="">
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6 m-auto">
				<div class="contact__help-item white-bg text-center mb-30 wow fadeInLeft px-4 pb-3" data-wow-delay=".3s">
					<div class="contact__text">
						<form method="POST" action="{{ route('login') }}" class="w-100">
							@csrf

							<div class="form-group row">
								<label for="email" class="col-md-4 col-form-label text-left">{{ __('E-Mail Address') }}</label>

								<div class="col-md-8">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

									@error('email')
									<span class="invalid-feedback text-left">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="form-group row">
								<label for="password" class="col-md-4 col-form-label text-left">{{ __('Password') }}</label>

								<div class="col-md-8">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

									@error('password')
									<span class="invalid-feedback text-left">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="form-group row">
								<div class="col-12">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

										<label class="form-check-label" for="remember">
											{{ __('Remember Me') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-12">
									<button type="submit" class="z-btn">{{ __('Login') }}</button>

									@if (Route::has('password.request'))
									<a class="btn btn-link" href="{{ route('password.request') }}">
										{{ __('Forgot Your Password?') }}
									</a>
									@endif
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-12">
									<hr>
									Do not have an account yet? <a class="btn btn-link" href="{{ route('register') }}">Register</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop