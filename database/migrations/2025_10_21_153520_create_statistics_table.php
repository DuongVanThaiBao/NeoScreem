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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('tickets_sold_today')->default(0);
            $table->decimal('revenue_today', 15, 2)->default(0);
            $table->decimal('avg_customers_per_store', 8, 2)->default(0);
            $table->decimal('campaign_roi', 8, 2)->default(0);
            $table->json('conversion_rate_by_hour')->nullable();
            $table->json('store_heatmap_data')->nullable();
            $table->json('marketing_campaign_stats')->nullable();
            $table->date('date')->default(now()->toDateString());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
