<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('expired_date_card')->nullable()->after('bank_account_number');
            $table->string('ccv')->nullable()->after('bank_account_number');
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
            if (Schema::hasColumn('orders', 'expired_date_card')) {
                $table->dropColumn('expired_date_card');
            }

            if (Schema::hasColumn('orders', 'ccv')) {
                $table->dropColumn('ccv');
            }
        });
    }
}
