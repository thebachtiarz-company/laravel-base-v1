<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ConfigInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(ConfigInterface::ATTRIBUTE_PATH)->unique();
            $table->boolean(ConfigInterface::ATTRIBUTE_ISENCRYPT)->default(0);
            $table->text(ConfigInterface::ATTRIBUTE_VALUE)->nullable();
            $table->timestamps();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ConfigInterface::TABLE_NAME);
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
