<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePebbleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $routeTableNames = config('pebble-routes.table_names');

        if (!Schema::hasTable($routeTableNames['routes'])) {
            $fallbackLocale = config('app.fallback_locale');

            Schema::create($routeTableNames['routes'], function (Blueprint $table) use ($fallbackLocale) {
                $table->bigIncrements('id');
                $table->string('uri');
                $table->string('prefix')->nullable();
                $table->string('namespace')->default("\\App\\Http\\Controllers");
                $table->json('verbs');
                $table->string('action');
                $table->string('locale')->default($fallbackLocale);
                $table->json('defaults')->nullable();
            });
        }

        if (!Schema::hasTable($routeTableNames['middlewares'])) {
            Schema::create($routeTableNames['middlewares'], function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
            });
        }

        if (!Schema::hasTable($routeTableNames['redirections'])) {
            Schema::create($routeTableNames['redirections'], function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uri');
                $table->string('destination');
                $table->string('status')->default(301);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $routeTableNames = config('pebble-routes.table_names');

        Schema::dropIfExists($routeTableNames['routes']);
        Schema::dropIfExists($routeTableNames['middlewares']);
        Schema::dropIfExists($routeTableNames['redirections']);
    }
}
