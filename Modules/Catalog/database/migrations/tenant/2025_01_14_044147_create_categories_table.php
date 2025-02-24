<?php

use App\Enums\StatusEnum;
use App\Enums\GoodsTypeEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name')->nullable()->default(null);
            $table->string('slug');
            $table->json('icon')->nullable();
            $table->json('photo')->nullable();
            $table->json('photo_focus')->nullable();
            $table->decimal('coefficient', 10, 1)->nullable()->default(0);
            $table->decimal('coefficient_commissioner', 10, 1)->nullable()->default(0);
            $table->decimal('coefficient_extra', 10, 1)->nullable()->default(0);
            $table->unsignedTinyInteger('status')->default(StatusEnum::DRAFT->value);
            $table->enum('type', [
                GoodsTypeEnum::PRODUCT->value, 
                GoodsTypeEnum::SPARE_PART->value, 
                GoodsTypeEnum::MERCH->value
            ]);
            $table->unsignedBigInteger('position')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->unsignedInteger('_lft')->default(0)->nullable(false);
            $table->unsignedInteger('_rgt')->default(0)->nullable(false);

            $table->index(['status', 'type']);
            $table->index('position');
            $table->foreign('parent_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
