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
            ["type" => "user_status"], 
            ["type" => "admin_role"], 
            ["type" => "admin_status"], 
            ["type" => "product_platform"], 
            ["type" => "product_status"],
            ["type" => "product_sale"],
            ["type" => "product_featured"],
            ["type" => "system_category"], 
            ["type" => "order_payment"],
            ["type" => "order_status"]
        );

        DB::table('tbl_cms')->insert($cms);
    }
}
