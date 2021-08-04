<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>{{ (isset($pageTitle) ? $pageTitle . ' | ' : '') }} {{ config('app.name') }} </title>
	<meta name="author" content="OSO Developers">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- convert pages of pdf file into images -->
	<script src="{{ asset('js/pdfjs/pdf.js') }}"></script>
</head>

<body>
	<div id="app">
		@yield('content')
	</div>
</body>

</html>