@extends('admin.layouts.master')

@section('content')

	<div class='col-5'>
		<form action='/admin/clients/{{$user->id}}' method='POST'>
			{{csrf_field()}}
			{{method_field('PATCH')}}

			<div class='input-field'>
				<label for='line_1'>Line 1</label>
				<input type='text' name='line_1'>
			</div>
			
			<div class='input-field'>
				<label for='line_2'>Line 2</label>
				<input type='text' name='line_2'>
			</div>
			
			<div class='input-field'>
				<label for='city'>City</label>
				<input type='text' name='city'>
			</div>
			
			<div class='input-field'>
				<label for='postcode'>Postcode</label>
				<input type='text' name='postcode'>
			</div>

			<button class="button" type="submit" name='add_delivery'>Save Address</button>

		</form>
	</div>

@endsection