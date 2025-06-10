<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'pickup_scheduled', 'picked_up', 'processing', 'ready', 'out_for_delivery', 'delivered', 'cancelled'])->default('pending');
            
            // Pickup Information
            $table->date('pickup_date');
            $table->string('pickup_time_slot');
            $table->text('pickup_address');
            $table->text('pickup_instructions')->nullable();
            
            // Delivery Information
            $table->date('delivery_date')->nullable();
            $table->string('delivery_time_slot')->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('delivery_instructions')->nullable();
            
            // Services and Pricing
            $table->json('services'); // Store selected services
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            
            // Payment Information
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_transaction_id')->nullable();
            
            // Tracking Information
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            // Additional Information
            $table->text('special_instructions')->nullable();
            $table->integer('estimated_items_count')->default(0);
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};