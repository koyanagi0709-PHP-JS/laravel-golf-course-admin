<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('golf_courses', function (Blueprint $table) {
            # Primary Key
            $table->bigIncrements('id');
            
            # 多言語・国コード
            $table->string('locale',2);
            $table->string('country_code',2);

            # 基本情報
            $table->string('state_prefecture')->nullable(); // 都道府県
            $table->string('course_name'); //施設名
            $table->integer('kinds')->nullable(); // 分散コード
            $table->text('web')->nullable(); // 公式サイトURL
            $table->string('phone')->nullable(); // 電話番号
            $table->string('address')->nullable(); // 住所
            
            # 種別フラグ（４つ）
            $table->boolean('indoor')->default(false); // 室内コースか
            $table->boolean('outdoor')->default(false); // 屋外コースか
            $table->boolean('short_course')->default(false);//ショートコースか
            $table->boolean('long_course')->default(false);//ロングコースか

            # 位置情報 桁指定なし MySQL8.0.17以降でdouble(20,15)は非推奨のため
            $table->double('lat')->nullable(); // 緯度 -90 ～ 90
            $table->double('lng')->nullable(); // 経度 -180 ～ 180

            # 予約・問い合わせ
            $table->string('form_email')->nullable(); //問い合わせメールアドレス
            $table->string('reservation')->nullable();//予約先URL/番号
            $table->string('reservation_method')->nullable();//予約手段（電話/WEB/メール等）

            # 備考・画像
            $table->text('remarks')->nullable(); // 備考
            $table->string('image1')->nullable(); //画像１ファイルパス
            $table->string('image2')->nullable(); //画像２ファイルパス
            $table->string('image3')->nullable(); //画像３ファイルパス

            # タイムスタンプ Eloquent自動管理
            $table->timestamps();

            # インデックス（検索高速化）
            $table->index('country_code');
            $table->index('locale');
            $table->index('state_prefecture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('golf_courses');
    }
};
