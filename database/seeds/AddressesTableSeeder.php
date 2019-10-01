<?php

use App\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
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
				'user_id' => 2,
				'line_1' => 'Manchester Campus',
				'Line_2'=>'Fields',
				'postcode' => 'M14 5FJ',
				'city' => 'Manchester',
				'primary' => true,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'user_id' => 2,
				'line_1' => '23 West Regent Street',
				'Line_2'=>'',
				'postcode' => 'G21 2AA',
				'city' => 'Glasgow',
				'primary' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'user_id' => 2,
				'line_1' => 'Work',
				'Line_2'=>'2 Sheffield Street, Soho',
				'postcode' => 'W2F 8CH',
				'city' => 'London',
				'primary' => false,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
		];
	
	Address::truncate();
	Address::insert($data);

	}
}
