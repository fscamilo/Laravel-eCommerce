@extends('admin.layouts.master')

@section('content')

    @include('auth.register');
    
    @include('global.errors.form-errors')

@endsection