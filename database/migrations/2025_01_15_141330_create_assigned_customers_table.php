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
        Schema::create('assigned_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')// is an admin
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_customers');
    }
};
