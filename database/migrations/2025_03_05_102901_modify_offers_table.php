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
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('offer_duration');
            $table->foreignId('sector_id')->nullable()->constrained('sector');
            $table->date('start_offer');
            $table->date('end_offer');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropForeign('sector_id');
            $table->dropColumn('start_offer');
            $table->dropColumn('end_offer');
            $table->string('offer_duration');
            //
        });
    }
};
