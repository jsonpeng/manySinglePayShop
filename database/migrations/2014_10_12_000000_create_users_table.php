<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->comment('用户名');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('password')->nullable()->comment('密码');

            $table->string('head_image')->nullable()->comment('用户头像');
            
            #唯一性
            $table->string('mobile')->nullable()->comment('手机号');

            $table->timestamp('last_login')->nullable()->comment('最后登录日期');
            $table->string('last_ip')->nullable()->comment('最后登录IP');

            $table->string('des')->nullable()->comment('个人简介');
            $table->string('type')->nullable()->default('用户')->comment('用户(游客) 个人 媒体 企业');

            $table->double('zichan')->nullable()->default(0)->comment('资产');
            $table->double('fuzhai')->nullable()->default(0)->comment('负债');
            $table->string('brief')->nullable()->comment('个人简介');

            $table->string('official_accounts_name')->nullable()->comment('公众号名称');
            $table->string('official_accounts_erweima')->nullable()->comment('公众号二维码');
            $table->string('sex')->nullable()->comment('性别 男/女');
            $table->string('weixin')->nullable()->comment('登录微信');
            $table->string('openid')->nullable()->comment('微信openid');

            $table->integer('good_writer')->nullable()->default(0)->comment('优秀作家 0不是1是');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
