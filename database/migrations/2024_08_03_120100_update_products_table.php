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
        Schema::table('products', function (Blueprint $table) {
            // Check if the columns exist before renaming them
            if (Schema::hasColumn('products', 'brand')) {
                $table->renameColumn('brand', 'brand_id');
            }
            if (Schema::hasColumn('products', 'featured')) {
                $table->renameColumn('featured', 'is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback column renames
            if (Schema::hasColumn('products', 'brand_id')) {
                $table->renameColumn('brand_id', 'brand');
            }
            if (Schema::hasColumn('products', 'is_featured')) {
                $table->renameColumn('is_featured', 'featured');
            }
        });
    }
};
