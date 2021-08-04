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
					<h2>{{ $document->name }}</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item active text-light" aria-current="page">{{ $document->name }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about__area py-5">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6">
				<h3>Choose a USA State</h3>
				<p>A legal document can vary in format between different USA States. Please select the appropriate state from below.</p>
			</div>
		</div>

		<form action="/make-documents/{{ $document->slug }}" method="POST">
			<div class="row mt-3">
				<div class="col-12 col-sm-6 col-md-4">
					@csrf
					<select class="form-control" name="variation" id="state">
						@foreach ($document->variations as $variation)
						<option value="{{ $variation->id }}">{{ $variation->state }}</option>
						@endforeach
					</select>
				</div>

				<div class="col-12 col-sm-6 col-md-4">
					<button id="submit" type="submit" class="btn btn-primary">Make Document</button>
				</div>
			</div>
		</form>

		<div class="row">
			<div class="col-12 col-sm-6">
				<small>* General means the Document Template is same for all USA States</small>
			</div>
		</div>
	</div>
</section>

@if (count($document->question_answer) > 0)
<section class="py-5">
	<div class="container">
		<h3>Making a {{ $document->name }}</h3>
		<hr />
		@foreach ($document->question_answer as $question)
		<div class="faq pt-3 pb-5">
			<h5 class="faq__question pb-2">{{ $question->question }}</h5>
			<p class="faq__answer">{{ $question->answer }}</p>
		</div>
		@endforeach
	</div>
</section>
@endif

@endsection