@extends('admin.layouts.master')

@section('content')

	<div class='col-12 dashboard'>
		@include('admin.partials.dashboard.'.$user_role)
	</div>

@endsection