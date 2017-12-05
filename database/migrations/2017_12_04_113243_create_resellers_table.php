<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resellers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('market_id');
            $table->unsignedInteger('parent_id');
            $table->string('reseller_type', 50);
            $table->string('code', 50);
            $table->string('name', 50);
            $table->string('owner', 50);
            $table->string('pic', 50);
            $table->string('phone1', 50);
            $table->string('phone2', 50)->nullable();
            $table->string('email', 150);
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resellers');
    }
}
