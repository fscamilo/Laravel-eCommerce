<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
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
				'sku' => 1001,
				'name'=>'Green tree',
				'description' => 'Green tree 8 meters high, no fruits.',
				'price' => 10,
				'category_id' => 2,
				'image' => 'tree.jpg',
				'force_popular' => false,
				'force_new' => false,
				'force_sale' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'sku' => 1002,
				'name'=>'Pine',
				'description' => 'Pine, squirrels not included.',
				'price' => 12,
				'category_id' => 2,
				'image' => 'pine.jpg',
				'force_popular' => false,
				'force_new' => false,
				'force_sale' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'sku' => 1003,
				'name'=>'Bush',
				'description' => 'Regular bush.',
				'price' => 5,
				'category_id' => 3,
				'image' => 'bush.jpg',
				'force_popular' => false,
				'force_new' => false,
				'force_sale' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'sku' => 1004,
				'name'=>'Apple tree',
				'description' => 'It may provide some food.',
				'price' => 20,
				'category_id' => 2,
				'image' => 'tree.jpg',
				'force_popular' => false,
				'force_new' => false,
				'force_sale' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'sku' => 1005,
				'name'=>'Christmas Tree',
				'description' => 'Bottom area fits several gifts.',
				'price' => 40,
				'category_id' => 2,
				'image' => 'pine.jpg',
				'force_popular' => false,
				'force_new' => false,
				'force_sale' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
		];
		
		Product::truncate();
		Product::insert($data);

    }
}
