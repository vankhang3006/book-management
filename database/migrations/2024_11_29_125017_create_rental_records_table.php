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
        Schema::create('rental_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_copy_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Người thuê
            $table->date('rented_at'); // Ngày thuê
            $table->date('due_date'); // Ngày hạn trả
            $table->date('returned_at')->nullable(); // Ngày trả thực tế (nếu có)
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
        Schema::dropIfExists('rental_records');
    }
};
