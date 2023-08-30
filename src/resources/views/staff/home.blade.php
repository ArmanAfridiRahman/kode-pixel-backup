@extends('admin.layouts.master')
@section('content')

<h1>Hello {{Auth::user()->name}}</h1>
<a href="{{route('staff.logout')}}" class="pointer dropdown-item"> 
    {{translate('logout')}}
  </a>
@endsection




