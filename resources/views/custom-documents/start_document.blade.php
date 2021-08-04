@extends('layout.dashboard')
@section('content')

<create-custom-user-document
  :user={{ $user }}
></create-custom-user-document>

@endsection