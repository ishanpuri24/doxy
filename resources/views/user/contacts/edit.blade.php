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
					<h2>{{ isset($contact) ? $contact->contact_name : $pageTitle }}</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item"><a href="{{ route('user.contacts') }}">My Contacts</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about__area pb-150 pt-150">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="m-img wow fadeInLeft" data-wow-delay=".2s">
					<img src="{{ asset('assets/img/contacts/1.svg') }}" alt="">
				</div>
			</div>

			<div class="col-md-8">
				<form method="POST" action="{{ route('user.contact', isset($contact) ? $contact : NULL) }}" class="w-100">
					@csrf

					<div class="form-group row">
						<label for="contact_name" class="col-md-4 col-form-label text-left">Name</label>

						<div class="col-md-8">
							<input id="contact_name" type="text" class="form-control @error('contact_name') is-invalid @enderror" name="contact_name" value="{{ isset($contact) ? $contact->contact_name : '' }}" required autocomplete="contact_name" autofocus>

							@error('contact_name')
							<span class="invalid-feedback text-left">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="contact_email" class="col-md-4 col-form-label text-left">Email</label>

						<div class="col-md-8">
							<input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ isset($contact) ? $contact->contact_email : '' }}" required>

							@error('contact_email')
							<span class="invalid-feedback text-left">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="contact_mobile_number" class="col-md-4 col-form-label text-left">Mobile Number</label>

						<div class="col-md-8">
							<input id="contact_mobile_number" type="text" class="form-control @error('contact_mobile_number') is-invalid @enderror" name="contact_mobile_number" value="{{ isset($contact) ? $contact->contact_mobile_number : '' }}" required>

							@error('contact_mobile_number')
							<span class="invalid-feedback text-left">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="contact_address" class="col-md-4 col-form-label text-left">Address</label>

						<div class="col-md-8">
							<input id="contact_address" type="text" class="form-control @error('contact_address') is-invalid @enderror" name="contact_address" value="{{ isset($contact) ? $contact->contact_address : '' }}">

							@error('contact_address')
							<span class="invalid-feedback text-left">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="contact_address" class="col-md-4 col-form-label text-left">Description</label>

						<div class="col-md-8">
							<textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ isset($contact) ? $contact->description : '' }}</textarea>

							@error('description')
							<span class="invalid-feedback text-left">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row pt-4 justify-content-between">
						<a href="{{ route('user.contacts') }}" class="z-btn btn-default border-primary float-left">Back</a>

						@if(isset($contact))
						<a onclick="return confirm('Are you sure?')" ; href="{{ route('user.contact.delete', $contact->id) }}" class="z-btn btn-danger float-left">Delete Contact</a>
						@endif

						<button type="submit" class="z-btn float-right">{{ isset($contact) ? 'Update' : 'Add' }} Contact</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@stop