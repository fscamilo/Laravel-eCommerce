@extends('admin.layouts.master')

@section('content')

    <div class='col-12 users-grid'>

    <h1>All Clients</h1>

    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created</th>
            <th></th>
        </thead>
        @foreach($users as $user)
        <tr>
            <td data-label='ID'>{{$user->id}}</td>
            <td data-label='Name'>{{$user->name}}</td>
            <td data-label='Email'>{{$user->email}}</td> 
            <td data-label='Created'>{{$user->created_at->toFormattedDateString()}}</td>
            <td class='button-cell'><a class='button' href='/admin/clients/{{$user->id}}'>Edit</a></td>
        </tr>
        @endforeach
    </table>

    @if(session('delete_response'))
        @include('global.messages.destroy-message')
    @endif

@endsection