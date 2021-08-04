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
					<h2>{{ $page_title }}</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item active text-light" aria-current="page">{{ $page_title }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="blog__area py-5 bg-white">
	<div class="container">
		<div class="row">
			<div class="col-12 mb-2 pb-4 text-center">
				<h1>LOREM IPSUM DOLOR</h1>
				<p class="text-secondary">Lorem ipsum dolor ipsum dolor ipsum dolor ipsum dolor ipsum dolor</p>
			</div>
		</div>

		<div class="row">
			@foreach($document_categories as $category)
			@if (count($category->documents) > 0)
			<div class="col-12 col-md-6 col-lg-4">
				<h4>{{ $category->name }}</h4>

				<ul>
					@foreach ($category->documents as $document)
					@if ($document->name != "Custom")
					<li><a href="/make-documents/{{ $document->slug }}">{{ $document->name }}</a></li>
					@endif
					@endforeach
				</ul>
			</div>
			@endif
			@endforeach
		</div>

		<div class="row">
			<div class="col-12 text-center mt-4 pt-4">
				<hr class="hr" data-type="or">
				<a class="z-btn mt-4" href="/dashboard#request-signatures" target="_blank">Sign Documents</a>
			</div>
		</div>
	</div>
</section>
@stop