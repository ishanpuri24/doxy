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
					<h2>{{ $document_name }}</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item"><a href="{{ route('documents.make') }}">Make Documents</a></li>
							<li class="breadcrumb-item active text-light" aria-current="page">{{ $document_name }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="blog__area mt-neg-5">
	<div class="container">
		<div class="row">
			<create-user-document
				:document-variation-id="{{ $document_variation_id }}"
				:field-groups="{{ $document_field_groups }}"
				:template-images="{{ $template_images }}"
			></create-user-document>
		</div>
	</div>
</section>

@endsection