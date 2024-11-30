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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id'); // Khóa ngoại
            $table->string('code')->unique(); // Mã bản sao
            $table->enum('status', ['available', 'borrowed', 'damaged', 'lost'])->default('available');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_copies');
    }
};
