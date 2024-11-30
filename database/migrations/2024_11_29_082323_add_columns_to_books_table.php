<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('publisher')->nullable()->after('author');
            $table->date('published_date')->nullable()->after('publisher');
            $table->string('image')->nullable()->after('description');      
            $table->integer('copies_count')->default(0)->after('published_date'); // Số bản sao
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['publisher', 'published_date', 'image', 'copies_count']);
        });
    }
};
