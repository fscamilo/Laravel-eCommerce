@extends('admin.layouts.master')

@section('content')

<div class='container'>
		<div class='float-right'>
			Search driver: <input type="search" id="searchDriver">
		</div>

		<div id='allDrivers'>
			<table class='table table-hover'>
				<thead class='thead-dark'>
					<th>Name</th>
					<th>Email</th>
					<th>Total deliveries</th>
					<th>Average rating</th>
				</thead>
			
				@foreach ($drivers as $driver)
					<tr class='driver'>
						<input class='driverId' type="hidden" value={{$driver->id}}>
						<td>{{$driver->name}}</td>
						<td>{{$driver->email}}</td>
						<td>{{$driver->total_deliveries}}</td>
						<td>{{number_format($driver->rating_average, 1)}}/5</td>
					</tr>
				@endforeach

			</table>
		</div>
	
		<div class='modal fade' id='driverDetail'>
			<div class='modal-dialog'>
				<div class='modal-content' id='driverDetailContent'>
					<!-- Content here -->
				</div>
			</div>
		</div>
	</div>

@endsection

