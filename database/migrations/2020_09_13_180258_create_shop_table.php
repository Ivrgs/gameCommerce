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
            $table->string('product_slug');
            $table->text('product_description');
            $table->string('product_platform');
            $table->float('product_price', 8, 2);
            $table->integer('product_quantity');
            $table->integer('product_status');
            $table->integer('sale');
            $table->float('sale_price', 8, 2)->nullable();
            $table->integer('product_featured');
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
