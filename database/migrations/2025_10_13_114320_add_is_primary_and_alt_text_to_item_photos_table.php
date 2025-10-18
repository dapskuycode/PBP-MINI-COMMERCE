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
        Schema::table('item_photos', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('url');
            $table->boolean('is_primary')->default(false)->after('alt_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_photos', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'is_primary']);
        });
    }
};
