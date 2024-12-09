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
        Schema::create('subscription_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('period');
            $table->bigInteger('cost');
            $table->unsignedTinyInteger('discount')->default(0);
            $table->smallInteger('number_of_usage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_offers');
    }
};
