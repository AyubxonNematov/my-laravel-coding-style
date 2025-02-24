<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Catalog\Enum\SpecificationTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name')->nullable()->default(null);
            $table->enum('type', [
                SpecificationTypeEnum::DROPDOWN->value, 
                SpecificationTypeEnum::CHECKBOX_MULTIPLE->value, 
                SpecificationTypeEnum::FREE->value, 
                SpecificationTypeEnum::RANGE->value
            ])->nullable();
            $table->boolean('filter')->nullable()->default(false);
            $table->smallInteger('position')->nullable()->default(0);
            $table->foreignUuid('leaf_category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['filter', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
