<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Product extends Model
{
	protected $table = 'order_products';

    protected $fillable = [
		'order_id', 'product_id', 'name', 'price', 'quantity',
	];

	public function order(){
        return $this->belongsTo('App\Order');
	}

	public function product(){
        return $this->belongsTo('App\Products');
	}
 
}
