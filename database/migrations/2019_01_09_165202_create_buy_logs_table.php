<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuyLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->float('price')->comment('购买金额');
            $table->string('name')->comment('收货人姓名');
            $table->string('mobile')->comment('收货人手机号');
            $table->string('address')->comment('收货人地址');
            $table->enum('pay_status',['已支付','未支付','已取消'])->nullable()->default('未支付')->comment('支付状态');
            $table->enum('pay_platform',['支付宝','微信'])->comment('支付平台');
            $table->string('number')->nullable()->comment('订单号');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'created_at']);
            $table->index('pay_status');
            $table->index('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('buy_logs');
    }
}
