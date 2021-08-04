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
 							<li class="breadcrumb-item active text-light" aria-current="page">{{ $pageTitle }}</li>
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
 			<div class="col-12">
 				<a href="/make-documents" target="_blank" class="btn btn-primary">Start Document with User</a>
			 </div>
 		</div>


 		<div class="row">
 			<div class="col-12">
 				<h3>Details</h3>
 				<table style="border-collapse: separate; border-spacing: 0 1.5rem;">
 					<tbody>
 						<tr>
 							<td class="font-weight-bold pr-4">Name</td>
 							<td>{{ $contact->contact_name }}</td>
 						</tr>
 						<tr>
 							<td class="font-weight-bold pr-4">Email</td>
 							<td>{{ $contact->contact_email }}</td>
 						</tr>
 						<tr>
 							<td class="font-weight-bold pr-4">Mobile</td>
 							<td>{{ $contact->contact_mobile_number }}</td>
 						</tr>
 						<tr>
 							<td class="font-weight-bold pr-4">Address</td>
 							<td>{{ $contact->contact_address }}</td>
 						</tr>
 					</tbody>
 				</table>
 			</div>
 		</div>

 		<div class="row mt-4">
 			<div class="col-12">
 				<h3>History</h3>
 				<div class="text-center py-3">
 					<span>No documents with this user</span>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>
 @stop