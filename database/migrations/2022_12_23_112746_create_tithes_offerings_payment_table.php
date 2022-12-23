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
        Schema::create('tithes_offerings_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tithe_offering_id')
                ->constrained('tithes_offerings')
                ->onDelete('cascade');
            $table->foreignId('payment_type')
                ->nullable()
                ->constrained('tithes_offerings_payment_types')
                ->nullOnDelete();
            $table->decimal('amount');
            $table->date('payed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tithes_offerings_payment');
    }
};
