<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_parent()
    {
        return $this->belongsTo('App\User', 'parent');
	}
	
	public function baskets()
    {
        return $this->hasMany('App\Basket');
	}
	
	public function addresses()
    {
        return $this->hasMany('App\Address');
	}

	public function primary_address()
    {
        return $this->belongsTo('App\Address', 'primary_address_id');
	}
	
	public function order_assigned()
    {
        return $this->hasMany('App\Order', 'driver_id');
	}
	
	public function getRatingAverageAttribute(){
		return ($this->total_deliveries >0 ? $this->order_assigned->sum('rating') / $this->total_deliveries : '-');
	}

	public function getTotalDeliveriesAttribute(){
		return $this->order_assigned->where('delivered_at', '<>', null)->count();
	}
}