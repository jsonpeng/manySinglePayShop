<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSharePlatformsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_platforms', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('广告平台名称');
            $table->string('link')->nullable()->comment('平台网址');
            $table->string('qrcode')->nullable()->comment('平台二维码');

            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('share_platforms');
    }
}
