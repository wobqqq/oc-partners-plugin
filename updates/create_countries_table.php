<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blackseadigital_partners_countries', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('name');
            $table->string('external_id')->index()->nullable();
            $table->smallInteger('sort_order')->nullable()->unsigned();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blackseadigital_partners_countries');
    }
};
