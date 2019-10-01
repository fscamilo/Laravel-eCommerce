<?php

namespace App\Http\Controllers\admin;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
		if(Auth::user()->role == 'administrator'){
			$orders = Order::all();
		}else{
			$orders = Order::where('user_id', Auth::user()->id)->get();
		}

		return view('admin.pages.orders.index', ['orders' => $orders]);
	}

	public function orderDetail(Request $request){
		$orderId = $request->message;
		$order = Order::find($orderId)->first();

		if($order->user_id === Auth::user()->id
			|| Auth::user()->role === 'administrator'
			|| (Auth::user()->role === 'driver' && $order->driver_id === Auth::user()->id))
			{
			$result = [
				'html' => view(
					'admin.partials.orders.detail',
					['order' => $order]
				)->render(),
			];
			return response()->json($result);
		}else{
			return response()->json(['html' => 'Access Denied']);
		}
	}

	public function orderUpdate(Request $request){
		$data = $request->message;
		$order = Order::find($data['orderId']);

		$old_driver = $order->driver_id;
		$old_deliver = $order->deliver_estimate;

		$order->driver_id = $data['driverId'];
		$order->deliver_estimate = $data['deliverDate'];
		$order->save();

		if($old_driver <> $order->driver_id){
			// Send email to driver when assigned
		}
		if($old_deliver <> $order->deliver_estimate){
			// Send email to client if delivery date has changed
		}

		$result = [
			'success' => true,
		];

		return response()->json($result);
	}

	public function deliverUpdate(Request $request){
		$data = $request->message;
		$order = Order::find($data['orderId']);
		$status = $data['status'];
		
		if($status == 'delivered'){
			$order->delivered_at = Carbon::now();
			$order->save();

			// Send email to client confirming delivery and asking for review

			$result = ['updated' => true];
		}else{
			$result = ['updated' => false];
		}

		return response()->json($result);
	}

	public function reviewOrder(Request $request, $id){

		$order = Order::find($id);
		if(!$order || $order->user_id <> Auth::user()->id){abort(404);}

		if($request->input()){
			$order->feedback = $request->input('feedback');
			$order->rating = $request->input('feedback_face');
			$order->save();
		}

		return view('admin.pages.orders.review', ['order' => $order]);
	}
}