<?php

namespace App;

use App\Category;
use App\ProductsStock;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'name', 'sku', 'description', 'price', 'category_id',
		'force_popular', 'force_new', 'force_sale', 'image'
	];

    public function product_stock(){
        return $this->hasMany(ProductsStock::class);
	}
	
	public function category(){
        return $this->belongsTo(Category::class);
	}
	
	public function order(){
        return $this->hasMany(Order_Product::class);
	}

	public function getTotalSoldAttribute(){
		return $this->order->sum('quantity');
	}

	public function getCurrentStockAttribute(){
		return $this->product_stock->sum('base_stock') - $this->total_sold;
	}

	public function getTotalIncomeAttribute(){
        return $this->order->sum(function($order){
			return $order->quantity * $order->price;
		});
	}

	public function getAveragePriceAttribute(){
        return ($this->total_sold > 0 ? $this->total_income/$this->total_sold : $this->price);
	}

	public function getPopularFlagAttribute(){
        return ($this->total_sold >= 200 ? true : false);
	}

	public function getNewFlagAttribute(){
        return ($this->created_at->diffInDays(Carbon::now()) < 7 ? true : false);
	}
	
	public function getSaleFlagAttribute(){
        return ($this->price <= 0.8 * $this->average_price ? true : false);
	}
}