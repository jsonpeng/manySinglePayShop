<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuyItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('access_ip')->comment('访问ip');
            $table->string('product_name')->comment('商品名称');
            $table->string('product_img')->comment('商品图');
            $table->float('price')->comment('商品价格');
            $table->integer('num')->nullable()->default(1)->comment('商品数量');
            $table->integer('order_id')->nullable()->comment('订单id');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'created_at']);
            $table->index('access_ip');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('buy_items');
    }
}
