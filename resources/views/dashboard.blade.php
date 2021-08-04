@extends('layout.dashboard')
@section('content')

<dashboard user-json="{{ json_encode($auth_user) }}"></dashboard>

@endsection