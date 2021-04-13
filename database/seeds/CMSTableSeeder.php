<?php

use Illuminate\Database\Seeder;

class CMSTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cms = array(
            ["type" => "UserStatus"], 
            ["type" => "AdminRole"], 
            ["type" => "AdminStatus"], 
            ["type" => "ProductPlatform"], 
            ["type" => "ProductStatus"],
            ["type" => "ProductFeatured"],
            ["type" => "ProductPayment"],
            ["type" => "OrderStatus"]
        );

        DB::table('tbl_cms')->insert($cms);
    }
}
