<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    public function index($id = null){
		$drivers = User::where('role', 'driver');

		if($id <> null){
			$drivers = $drivers->find([$id]);
		}else{
			$drivers = $drivers->get();
		}

		return view('admin.pages.drivers.index', ['drivers' => $drivers]);
	}

	public function driverDetail(Request $request){
		$driverId = $request->input('message.driverId');
		$driver = User::find($driverId);

		$result = [
			'html' => view(
				'admin.partials.drivers.detail',
				['driver' => $driver]
			)->render(),
		];

		return response()->json($result);
	}
}
