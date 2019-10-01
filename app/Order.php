<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
		'user_id', 'reference', 'address_id', 'driver_id', 'deliver_estimate', 'feedback'
	];

	public function user(){
        return $this->belongsTo('App\User');
	}

	public function address(){
        return $this->belongsTo('App\Address');
	}

	public function product(){
        return $this->hasMany('App\Order_Product');
	}

	public function driver(){
        return $this->belongsTo('App\User', 'driver_id');
	}

	public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = substr(preg_replace('/\s+/', '', $value),2);
	}
	
	public function getTotalPriceAttribute(){
        return $this->product->sum(function($t){
			return $t->price * $t->quantity;
		});
	}

	public function getDeliveredAttribute(){
		return ($this->delivered_at ? true : false);
	}
}
