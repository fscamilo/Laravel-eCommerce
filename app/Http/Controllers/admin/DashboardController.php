<?php

namespace App\Http\Controllers\admin;

use App\User;
use App\Order;
use App\Basket;
use App\Product;
use App\Category;
use App\Order_Product;
use App\ProductsStock;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index(Request $request){
		$userRole = Auth::user()->role;
		$compact['user_role'] = $userRole;

		// ******************************** //
		// ******* CLIENT DASHBOARD	******* //

		if($userRole  == 'client'){
			$category_id = $request->input('categoryId');
			$product_search = $request->input('search');
			$sort = explode(' ', $request->input('sort'));

			if($request->has('categoryId')){
				if($category_id == 0){
					$filterCategory[] = ['category_id', '<>', $category_id];
				}else{
					$filterCategory[] = ['category_id', '=', $category_id];
				}
			}
			if($request->has('search')){
				$filterName[] = ['name', 'like', '%'.strtolower($product_search).'%'];
				$filterDescription[] = ['description', 'like', '%'.strtolower($product_search).'%'];
			}
			
			if(isset($filterCategory)){
				$compact['products'] = Product::
					where($filterCategory)
					->where(function($q) use($filterName, $filterDescription){
						$q->where($filterName)
						->orWhere($filterDescription);
					})
					->orderBy($sort[0], $sort[1])
					->get()
				;
				
				if($sort[0] == 'id'){
					$compact['products'] = $compact['products']->sortByDesc('total_sold')->sortByDesc('force_popular');
				}	
			}else{
				$compact['products'] = Product::all()->sortByDesc('total_sold')->sortByDesc('force_popular');
			}
			
			$compact['baskets'] = Basket::where('user_id', Auth::user()->id)->get();
			$compact['categories'] = Category::all();
		}

		// ******************************** //
		// ******* ADMIN DASHBOARD	******* //

		elseif($userRole  == 'administrator'){
			$compact['orders'] = Order::whereNull('delivered_at')->orderBy('created_at', 'asc')->get();
			$compact['deliveries'] = Order::whereDate('delivered_at', '>', Carbon::today()->subWeek())->get();
			$compact['drivers'] = User::where('role', 'driver')->get();
		}

		// ******************************** //
		// ******* DRIVER DASHBOARD	******* //

		elseif($userRole  == 'driver'){
			$show = $request->input('show');

			if($show =='all'){
				$compact['orders'] = Order::where('driver_id', Auth::user()->id)
					->orderBy('delivered_at')->get();
			}else{
				$compact['orders'] = Order::where('driver_id', Auth::user()->id)
					->whereNull('delivered_at')
					->orderBy('deliver_estimate')->get()
				;
			}
		}
		
		return view('admin.pages.dashboard.index', $compact);
	}


	public function addToCart(Request $request){
		$product = $request->message;
		$basket = Auth::user()->baskets->where('product_id', $product['productId'])->first();
		$inBasket = ($basket ? $basket->quantity : 0);
		if($inBasket < 0){ return response()->json('Not allowed'); }

		$newBasket = Basket::updateOrCreate(
			['user_id' => Auth::user()->id, 'product_id' => $product['productId']],
			['quantity' => $product['quantity'] + $inBasket]
		);

		$result = [
			'product' => $newBasket->product->name,
			'quantity' => $newBasket->quantity,
			'html' => $this->refreshBasket(),
		];		
		



		return response()->json($result);
	}

	public function removeFromCart(Request $request){
		$basketId = $request->message;
		Basket::destroy($basketId);

		$result = [
			'html' => $this->refreshBasket(),
		];

		return response()->json($result);
	}

	public function checkout() {
		$baskets = Basket::where('user_id', Auth::user()->id)->get();

		foreach ($baskets as $basket) {
			if($basket->product->current_stock < $basket->quantity){
				return response()->json([
					'success' => false,
					'productId' => $basket->product->id,
					'message' => view('global.messages.alert-quantity')->render(),
				]);
			}
		}

		$result = [
			'success' => true,
			'html' => view(
				'admin.partials.orders.checkout',
				['baskets' => Basket::where('user_id', Auth::user()->id)->get()]
			)->render(),
		];
		
		return response()->json($result);
	}

	public function placeOrder() {
		$baskets = Basket::where('user_id', Auth::user()->id)->get();

		foreach ($baskets as $basket) {
			if($basket->product->current_stock < $basket->quantity){
				return response()->json([
					'success' => false,
					'productId' => $basket->product->id,
					'message' => view('global.messages.alert-quantity')->render(),
				]);
			}
		}

		$order = Order::create([
			'user_id' => Auth::user()->id,
			'reference' => microtime(),
			'address_id' => 1,
		]);
		
		foreach ($baskets as $basket) {
			$order_product = Order_Product::create([
				'order_id' => $order->id,
				'product_id' => $basket->product->id,
				'name' => $basket->product->name,
				'price' => $basket->product->price,
				'quantity' => $basket->quantity,
			]);
		}
		
		$baskets->each->delete();

		$result = [
			'success' => true,
			'message' => view('global.messages.success-purchase')->render(),
			'html' => $this->refreshBasket(),
		];

		return response()->json($result);

	}

	private function refreshBasket(){
		return view(
				'admin.partials.dashboard.basket',
				['baskets' => Basket::where('user_id', Auth::user()->id)->get()]
			)->render();
	}
}
