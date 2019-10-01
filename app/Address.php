<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $table = 'addresses';
	
	public function user_primary()
    {
        return $this->hasOne('App\User', 'primary_address_id');
	}

	public function getIsPrimaryAttribute(){
		return (isset($this->user_primary) ? true : false);
	}

}
