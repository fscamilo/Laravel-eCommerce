<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{

	protected $fillable = [
		'user_id', 'product_id', 'quantity',
	]; 


    public function client(){
        return $this->belongsTo('App\User');
	}
	
	public function product(){
		return $this->belongsTo('App\Product');
	}

	public function getTotalPriceAttribute(){
		return $this->quantity * $this->product->price;
	}
}
	
