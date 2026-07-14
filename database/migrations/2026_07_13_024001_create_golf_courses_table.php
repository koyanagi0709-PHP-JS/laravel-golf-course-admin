<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行します（golf_coursesテーブルの作成）。
     * 
     * 設計書のスキーマ定義に基づき、PKの設定、適切なデータ型、制約（nullable）、
     * およびデータベース側にも説明が残るようcomment定義を付与してテーブルを作成します。
     */
    public function up(): void
    {
        Schema::create('golf_courses', function (Blueprint $table) {
            // 自動採番ID (主キー)
            $table->bigIncrements('id')->comment('自動採番ID');

            // 多言語・国コード
            $table->string('locale', 2)->comment('ロケール (ja/en等)');
            $table->string('country_code', 2)->comment('国コード (JP/US等)');

            // 基本情報
            $table->string('state_prefecture')->nullable()->comment('都道府県・州名');
            $table->string('course_name')->comment('施設名（コース名）');
            $table->integer('kinds')->nullable()->comment('分類コード');
            $table->text('web')->nullable()->comment('公式サイトURL');
            $table->string('phone')->nullable()->comment('代表電話番号');
            $table->string('address')->nullable()->comment('住所');

            // 種別フラグ（真偽値）
            $table->boolean('indoor')->default(false)->comment('室内コースか');
            $table->boolean('outdoor')->default(false)->comment('屋外コースか');
            $table->boolean('short_course')->default(false)->comment('ショートコースを持つか');
            $table->boolean('long_course')->default(false)->comment('ロングコースを持つか');

            // 位置情報（緯度経度）
            $table->double('lat')->nullable()->comment('緯度 (-90.0〜90.0)');
            $table->double('lng')->nullable()->comment('経度 (-180.0〜180.0)');

            // 予約・問い合わせ
            $table->string('form_email')->nullable()->comment('問い合わせメールアドレス');
            $table->string('reservation')->nullable()->comment('予約先URL／番号');
            $table->string('reservation_method')->nullable()->comment('予約手段（電話/WEB/メール等）');

            // 備考・画像パス
            $table->text('remarks')->nullable()->comment('備考');
            $table->string('image1')->nullable()->comment('画像1ファイルパス');
            $table->string('image2')->nullable()->comment('画像2ファイルパス');
            $table->string('image3')->nullable()->comment('画像3ファイルパス');

            // 作成日時・更新日時 (Eloquent自動管理)
            $table->timestamps();

            // インデックス設定 (検索の高速化)
            $table->index('country_code');
            $table->index('locale');
            $table->index('state_prefecture');
        });
    }

    /**
     * マイグレーションをロールバックします（golf_coursesテーブルの削除）。
     * 
     * up()メソッドで作成したテーブルを完全に削除（ドロップ）します。
     */
    public function down(): void
    {
        Schema::dropIfExists('golf_courses');
    }
};
