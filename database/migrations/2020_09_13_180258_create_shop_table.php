<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_shop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_image')->nullable();
            $table->string('product_name');
            $table->text('product_description');
            $table->string('product_platform');
            $table->float('product_price', 8, 2);
            $table->integer('product_quantity');
            $table->enum('product_status',['0','1','2']);
            $table->enum('sale',['0','1']);
            $table->float('sale_price', 8, 2)->nullable();
            $table->enum('featured',['0','1']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_shop');
    }
}
