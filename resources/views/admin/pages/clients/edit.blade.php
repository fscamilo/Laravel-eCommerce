@extends('admin.layouts.master')

@section('content')

    <div class='col-12 edit-user'>

        <h1>{{$user_role=='administrator' ? 'Edit Client' : 'Your Account'}}</h1>

        <form action='/admin/clients/{{$user->id}}/update' method='POST'>
            {{csrf_field()}}
            {{method_field('PATCH')}}

            <div class='input-field'>
                <label for='name'>Name</label>
                <input id='name' type='text' name='name' value='{{$user->name}}' required autofocus>
            </div>

            <div class='input-field'>
                <label for='email'>Email</label>
                <input id='email' type='email' name='email' value='{{$user->email}}' required>
            </div>

            <div class='input-field half'>
                <label for='password'>New Password</label>
                <input id='password' type='password' name='password'>
                <span id='toggle-pass'>show/hide</span>
            </div>

            <div class='input-field half'>
                <label>Repeat New Password</label>
                <input type='password' name='password_confirmation'>
            </div>

            @if($user_role=='administrator')
                <div class="input-field">
                    <label for="role">User Role</label>
                    <select id='role' name='role'>
                        @foreach(config('auth.user_roles') as $role)
                            <option value='{{$role}}' {{$user->role == $role ? 'selected' : null}}>{{$role}}</option>
                        @endforeach
                    </select>
                </div>
			@endif
            @isset($parent)
                <p>Created by user {{$parent->name}} at: {{$user->created_at->toFormattedDateString()}}</p>
			@else
				<p>Created at: {{$user->created_at->toFormattedDateString()}}</p>
            @endisset
			<p>Last Updated: {{$user->updated_at->toFormattedDateString()}}</p>

            <button class="button" type="submit">Update</button>
        </form>

        @if($user_role=='administrator')
            <a class='button delete' href={{route('client.delete', $user->id)}}>Delete User</a>
        @endif

        @if($user_role=='client')
            <div class='delivery-details'>
                <h3>Delivery Details</h3>

                <form action='#' method='POST'>
                    {{csrf_field()}}
					
					@foreach ($user->addresses as $address)
						<div class='input-field'>
							<textarea readonly>
	{{$address->line_1}}
	{{$address->line_2}}
	{{$address->postcode}}
	{{$address->city}}
							</textarea>
					
							<div class='checkbox-wrap'>
								<label>Make this your primary delivery address?</label>
								<input type="checkbox" name='primary-address' value='{{$address->id}}' {{($address->is_primary ? 'checked':'')}}>
								<span class='custom-checkbox {{($address->is_primary ? 'checked':'')}}'></span>
								<br>
								<a href='address/delete/{{$address->id}}'>Remove</a>
							</div>
						</div>
					@endforeach

                    <button class="button" type="submit" name='add_delivery'>Add Delivery Address</button>
                    <button class="button secondary" type="submit" name='update_delivery'>Update Delivery Addresses</button>
                </form>
            </div>
        @endif

    </div>

    @include('global.errors.form-errors')

    @if(session('user_delete_response'))
        @include('admin.pages.users.helpers.destroy-message')
    @endif

@endsection