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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('month');
            $table->decimal('basic_salary', 10, 2);
            $table->integer('working_days');
            $table->integer('loss_of_pay_days');
            $table->decimal('paid_days', 5, 2);
            $table->decimal('bonus', 10, 2)->default(0);
            $table->decimal('incentives', 10, 2)->default(0);
            $table->decimal('leave_deduction', 10, 2)->default(0);
            $table->integer('over_time_hours')->default(0);
            $table->decimal('over_time_rate', 10, 2)->default(0);
            $table->decimal('over_time_payment', 10, 2)->default(0);
            $table->decimal('net_pay', 10, 2);
            $table->string('payment_status');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
