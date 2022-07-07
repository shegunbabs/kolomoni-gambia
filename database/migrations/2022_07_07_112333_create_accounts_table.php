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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('transaction_tracking_ref')->nullable();
            $table->string('account_number');
            $table->string('bankone_account_number');
            $table->string('customer_id');
            $table->decimal('available_balance')->default(0);
            $table->decimal('withdrawable_balance')->default(0);
            $table->string('account_officer_code');
            $table->tinyInteger('account_tier');
            $table->timestamps();

            $table->index('account_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
