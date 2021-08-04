@extends('layout.app')
@section('content')

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/4.0.0/material-components-web.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.material.min.css">

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
                            <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">My Profile</a></li>
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
        <div class="col-12">
            <div class="row justify-content-between">
                <h2>{{ $pageTitle }}</h2>
                <a href="{{ route('documents.make') }}" class="z-btn">Add New</a>
            </div>
        </div>
        
        <div class="col-12 mt-4 pt-4 border-top">
            <div class="row">
                @if(sizeof($documents))
                    <table id="documentsTable" class="table w-100">
                        <thead>
                            <tr>
                                <th class="text-left">#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $keyD => $document)
                                <tr>
                                    <td class="text-left">{{ ++$keyD }}.</td>
                                    <td>{{ $document->document_name }}</td>
                                    <td>{{ config('constants.user.documents.status')[$document->status] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($document->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('user.documents', $document->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fal fa-pencil"></i>
                                        </a>
                                        <!-- &nbsp;|&nbsp; -->
                                        <!-- <a onclick="return confirm('Are you sure?')"; href="{{ route('user.contact.delete', $document->id) }}" data-toggle="tooltip" title="Delete">
                                            <i class="fal fa-trash"></i>
                                        </a> -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#documentsTable').DataTable({
                                "lengthChange": false,
                                "aaSorting": []
                            });
                        });
                    </script>
                @else
                    <div class="col-8 col-lg-5 m-auto">
                        <img src="{{ asset('assets/img/contacts/1.svg') }}" class="img-fluid">
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@stop