<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->required();
            $table->string('email')->nullable();
            $table->string('address')->required();
            $table->string('phone')->required();
            $table->string('type')->nullable();
            $table->integer('company_id')->required()->unsigned()->index();
            $table->integer('country_id')->unsigned()->index();
            $table->integer('language_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapters');
    }
}
