@extends('admin.layouts.master')

@section('content')

    <div class="col-md-9 admin-dashboard">
        <h1>Dashboard</h1>
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                You are logged in!
            </div>
        </div>
    </div>

@endsection
