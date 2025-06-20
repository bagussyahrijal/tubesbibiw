<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('service_type'); // wash_fold, dry_cleaning, ironing, etc.
            $table->string('item_type'); // shirt, pants, dress, etc.
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 8, 2)->default(0);
            $table->decimal('total_price', 8, 2)->default(0);
            $table->text('special_instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};