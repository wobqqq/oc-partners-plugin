<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blackseadigital_partners_partners', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->string('description', 14000)->nullable();
            $table->boolean('is_active')->default(0)->index();
            $table->boolean('is_online')->default(0);
            $table->boolean('is_offline')->default(0);
            $table->string('external_id')->index()->nullable();
            $table->smallInteger('category_id')->unsigned()->index();
            $table->string('online_points')->nullable();
            $table->string('interest_free_installments')->nullable();
            $table->string('offline_points')->nullable();
            $table->string('link')->nullable();
            $table->softDeletes();

            $table->foreign('category_id')
                ->references('id')
                ->on('blackseadigital_partners_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blackseadigital_partners_partners');
    }
};
