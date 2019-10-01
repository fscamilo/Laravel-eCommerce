<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class ProductsStock extends Model
{
	
	protected $table = 'products_stocks';

	protected $fillable = ['product_id', 'base_stock', 'current_stock'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}