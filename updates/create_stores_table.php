<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blackseadigital_partners_stores', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('address');
            $table->string('lat', 20)->nullable();
            $table->string('lon', 20)->nullable();
            $table->string('external_id')->index()->nullable();
            $table->smallInteger('city_id')->unsigned()->index();
            $table->smallInteger('country_id')->unsigned()->index();
            $table->smallInteger('partner_id')->unsigned()->index();
            $table->softDeletes();

            $table->foreign('country_id')
                ->references('id')
                ->on('blackseadigital_partners_countries');
            $table->foreign('city_id')
                ->references('id')
                ->on('blackseadigital_partners_cities');
            $table->foreign('partner_id')
                ->references('id')
                ->on('blackseadigital_partners_partners');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blackseadigital_partners_stores');
    }
};
