<?php

use App\ProductsStock;
use Illuminate\Database\Seeder;

class ProductsStocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
			array(
				'product_id' => 1,
				'base_stock' => 100,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'product_id' => 2,
				'base_stock' => 200,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),array(
				'product_id' => 3,
				'base_stock' => 300,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),array(
				'product_id' => 4,
				'base_stock' => 400,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),		];
		
		ProductsStock::truncate();
		ProductsStock::insert($data);
    }
}
