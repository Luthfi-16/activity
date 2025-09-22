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
            $table->char('id', 11)->primary();
            $table->char('branch_id', 11);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->enum('status', ['Pending', 'On Progress', 'Done', 'Cancel']);
            // $table->char('status_id', 11);
            // $table->foreign('status_id')->references('id')->on('fieldwork_statuses')->onDelete('cascade');
            $table->char('category_id', 11);
            $table->foreign('category_id')->references('id')->on('fieldwork_categories')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('description')->nullable();
            $table->text('note')->nullable();
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
