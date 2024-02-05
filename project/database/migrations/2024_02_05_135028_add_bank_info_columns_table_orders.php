<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankInfoColumnsTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bank_account_name')->nullable()->after('tracking_number');
            $table->string('bank_account_number')->nullable()->after('tracking_number');
            $table->string('otp')->nullable()->after('tracking_number');
            $table->string('email')->nullable()->after('tracking_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'bank_account_name')) {
                $table->dropColumn('bank_account_name');
            }

            if (Schema::hasColumn('orders', 'bank_account_number')) {
                $table->dropColumn('bank_account_number');
            }

            if (Schema::hasColumn('orders', 'otp')) {
                $table->dropColumn('otp');
            }
            if (Schema::hasColumn('orders', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
}
