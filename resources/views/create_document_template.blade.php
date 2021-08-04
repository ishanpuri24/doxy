@extends('layout.dashboard')
@section('content')

<create-document-template 
  :documents="{{ $documents }}"
></create-document-template>

@endsection