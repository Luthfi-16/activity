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
        Schema::create('fieldworks', function (Blueprint $table) {
            $table->char('id', 25)->primary();
            $table->string('description')->nullable();
            $table->text('note')->nullable();
            $table->char('branch_id', 25);
            $table->char('category_id', 25);
            $table->char('status_id', 25);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('fieldwork_categories')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('fieldwork_statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fieldworks');
    }
};
