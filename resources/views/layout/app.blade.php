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
	<link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/fontAwesome5Pro.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/elegantFont.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

	<script src="{{ asset('assets/js/vendor/jquery-3.5.1.min.js') }}" type='text/javascript'></script>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
	<div id="app">

		@if(Session::has('message'))
		<div class="ialert alert alert-{{ Session::has('alert-class') ? Session::get('alert-class') : 'default' }} alert-dismissible" role="alert">
			@if(Session::has('alert-class'))
			@if(Session::get('alert-class') == 'danger')
			<strong>Snap!</strong>
			@elseif(Session::get('alert-class') == 'success')
			<strong>Cool!</strong>
			@elseif(Session::get('alert-class') == 'warning')
			<strong>Warning!</strong>
			@endif
			@endif

			{{ Session::get('message') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif

		<div id="loading">
			<div id="loading-center">
				<div id="loading-center-absolute">
					<div class="object" id="object_one"></div>
					<div class="object" id="object_two"></div>
					<div class="object" id="object_three"></div>
					<div class="object" id="object_four"></div>
					<div class="object" id="object_five"></div>
					<div class="object" id="object_six"></div>
					<div class="object" id="object_seven"></div>
					<div class="object" id="object_eight"></div>
				</div>
			</div>
		</div>

		<header>
			<div class="header__area p-relative header__transparent">
				<div class="header__top d-none d-md-block">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-xl-6 col-lg-5 col-md-4">
								<div class="header__social">
									<ul>
										<li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
										<li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
										<li><a href="javascript:void(0);"><i class="fab fa-linkedin-in"></i></a></li>
										<li><a href="javascript:void(0);"><i class="fab fa-pinterest-p"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-xl-6 col-lg-7 col-md-8">
								<div class="header__info f-right">
									<ul>
										<li>
											<a href="tel:(+123)-456-789-012">
												<i class="fal fa-phone-alt"></i>
												(+123) 456 789 012
											</a>
										</li>
										<li>
											<a href="mailto:contact@doxy.ai">
												<i class="fal fa-envelope"></i>
												contact@doxy.ai
											</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="search-toggle">
												<i class="far fa-search"></i>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="header__sticky" class="header__bottom">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
								<div class="logo">
									<a href="/">
										<img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
									</a>
								</div>
								<div class="logo-gradient">
									<a href="/">
										<img src="{{ asset('assets/img/logo/logo-gradient.png') }}" alt="logo">
									</a>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-6 col-sm-6 col-6">
								<div class="header__bottom-right d-flex justify-content-end align-items-center">
									<div class="main-menu">
										<nav id="mobile-menu">
											<ul class="mb-0">
												<li class="d-xl-none">
													<a class="{{ Route::currentRouteName() == 'documents.make' ? 'active' : '' }}" href="{{ route('documents.make') }}">Make Documents</a>
												</li>
												@guest

												<li><a href="{{ route('login') }}">Login</a></li>
												<li><a href="{{ route('register') }}">Register</a></li>


												@else
												<li>
													<a href="{{ route('dashboard') }}">Dashboard</a>
												</li>


												<li>
													<a href="{{ route('user.profile') }}">My Profile</a>
												</li>

												<li>
													<a href="{{ route('user.contacts') }}">My Contacts</a>
												</li>

												<li>
													<a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
														{{ __('Logout') }}
													</a>
												</li>

												@endguest
											</ul>
										</nav>
									</div>
									<div class="header__btn d-none d-sm-block d-lg-none d-xl-block ml-50">
										<a href="{{ route('documents.make') }}" class="z-btn z-btn-white">Make Documents</a>
									</div>
									<div class="sidebar__menu d-lg-none">
										<div class="sidebar-toggle-btn" id="sidebar-toggle">
											<span class="line"></span>
											<span class="line"></span>
											<span class="line"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="header__search-wrapper">
					<div class="container">
						<div class="row">
							<div class="col-xl-12">
								<form action="">
									<input type="text" placeholder="Your Keywords">
									<button type="submit"><i class="far fa-search"></i></button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="body-overlay-2"></div>
			</div>
		</header>

		<section class="sidebar__area">
			<div class="sidebar__wrapper">
				<div class="sidebar__close">
					<button class="sidebar__close-btn" id="sidebar__close-btn">
						<span><i class="fal fa-times"></i></span>
						<span>close</span>
					</button>
				</div>
				<div class="sidebar__tab">
					<ul class="nav nav-tabs" id="sidebar-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="menu-tab" data-toggle="tab" href="#menu" role="tab" aria-controls="menu" aria-selected="true">menu</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">info</a>
						</li>
					</ul>
				</div>
				<div class="sidebar__content">
					<div class="tab-content" id="sidebar-tab-content">
						<div class="tab-pane fade show active" id="menu" role="tabpanel" aria-labelledby="menu-tab">
							<div class="logo mb-40">
								<a href="/">
									<img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
								</a>
							</div>
							<div class="mobile-menu"></div>
						</div>
						<div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
							<div class="sidebar__info">
								<div class="logo mb-40">
									<a href="/">
										<img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
									</a>
								</div>
								<p>We must explain to you how all seds this mistakens idea off denouncing pleasures and praising pain was born and I will give you a completed accounts of the system and expound.</p>
								<a href="javascript:void(0);" class="z-btn z-btn-white">contact us</a>
								<div class="sidebar__search">
									<form action="">
										<input type="text" placeholder="Your Keywords..">
										<button type="submit"><i class="fal fa-search"></i></button>
									</form>
								</div>
								<div class="sidebar__contact mt-30">
									<ul>
										<li>
											<div class="icon">
												<i class="fal fa-map-marker-alt"></i>
											</div>
											<div class="text">
												<span>Ave 14th Street, San Franciso, USA 3296.</span>
											</div>
										</li>
										<li>
											<div class="icon">
												<i class="fal fa-envelope"></i>
											</div>
											<div class="text ">
												<span><a href="mailto:contact@doxy.ai">contact@doxy.ai</a></span>
											</div>
										</li>
										<li>
											<div class="icon">
												<i class="fas fa-phone-alt"></i>
											</div>
											<div class="text">
												<span><a href="tel:(+123)-456-789-012">(+123) 456 789 012</a></span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="body-overlay"></div>

		<main>
			@yield('content')
		</main>

		<footer>
			<div class="footer__area grey-bg pt-5">
				<div class="footer__top pb-45">
					<div class="container">
						<div class="row">
							<div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
								<div class="footer__widget mb-45 wow fadeInUp" data-wow-delay=".2s">
									<div class="footer__widget-title">
										<h4>Company</h4>
									</div>
									<div class="footer__widget-content">
										<div class="footer__links">
											<ul>
												<li><a href="javascript:void(0);">Testimonials</a></li>
												<li><a href="javascript:void(0);">Consulting</a></li>
												<li><a href="javascript:void(0);">Partners</a></li>
												<li><a href="javascript:void(0);">Contact Us</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-2 offset-xl-1 col-lg-2 offset-lg-1 col-md-4 col-sm-6">
								<div class="footer__widget mb-45 wow fadeInUp" data-wow-delay=".4s">
									<div class="footer__widget-title">
										<h4>Resources</h4>
									</div>
									<div class="footer__widget-content">
										<div class="footer__links">
											<ul>
												<li><a href="javascript:void(0);">Customers</a></li>
												<li><a href="javascript:void(0);">Pricing</a></li>
												<li><a href="javascript:void(0);">News</a></li>
												<li><a href="javascript:void(0);">Help desk</a></li>
												<li><a href="javascript:void(0);">Support</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-2 offset-xl-1 col-lg-2 offset-lg-1 col-md-4 col-sm-6">
								<div class="footer__widget mb-45 wow fadeInUp" data-wow-delay=".6s">
									<div class="footer__widget-title">
										<h4>Use Cases</h4>
									</div>
									<div class="footer__widget-content">
										<div class="footer__links">
											<ul>
												<li><a href="javascript:void(0);">UI Design</a></li>
												<li><a href="javascript:void(0);">Agencies</a></li>
												<li><a href="javascript:void(0);">Digital Marketing</a></li>
												<li><a href="javascript:void(0);">SEO for Business</a></li>
												<li><a href="javascript:void(0);">Enterprise</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 offset-xl-1 col-lg-3 offset-lg-1 col-md-4 col-sm-6">
								<div class="footer__widget mb-45 wow fadeInUp" data-wow-delay=".8s">
									<div class="footer__widget-title">
										<h4>Information</h4>
									</div>
									<div class="footer__widget-content">
										<div class="footer__info">
											<ul>
												<li>
													<div class="icon">
														<i class="fal fa-map-marker-alt"></i>
													</div>
													<div class="text">
														<span>Ave 14th Street, Mirpur 210, San Franciso, USA 3296.</span>
													</div>
												</li>
												<li>
													<div class="icon theme-color ">
														<i class="fal fa-envelope"></i>
													</div>
													<div class="text theme-color ">
														<span><a href="mailto:contact@doxy.ai">contact@doxy.ai</a></span>
													</div>
												</li>
												<li>
													<div class="icon theme-color">
														<i class="fas fa-phone-alt"></i>
													</div>
													<div class="text theme-color">
														<span><a href="tel:(+123)-456-789-012">(+123) 456 789 012</a></span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer__copyright">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-xl-6 col-lg-6 col-md-6">
								<div class="footer__copyright-text">
									<p>Copyright © {{ date('Y') }} All Rights Reserved passion by <a href="/">doxy.ai</a></p>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6">
								<div class="footer__social theme-social f-right">
									<ul>
										<li>
											<a href="javascript:void(0);">
												<i class="fab fa-facebook-f"></i>
												<i class="fab fa-facebook-f"></i>
											</a>
										</li>
										<li>
											<a href="javascript:void(0);">
												<i class="fab fa-twitter"></i>
												<i class="fab fa-twitter"></i>
											</a>
										</li>
										<li>
											<a href="javascript:void(0);">
												<i class="fab fa-vimeo-v"></i>
												<i class="fab fa-vimeo-v"></i>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

	</div>

	<script src="{{ asset('assets/js/vendor/waypoints.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/jquery.meanmenu.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/slick.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/jquery.fancybox.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/jquery.counterup.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/owl.carousel.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/ajax-form.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/wow.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/main.js') }}" type='text/javascript'></script>
	<script src="{{ asset('assets/js/scripts.js') }}" type='text/javascript'></script>
</body>

</html>