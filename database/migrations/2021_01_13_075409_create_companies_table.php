<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->required();
            $table->string('email')->required();
            $table->string('address')->required();
            $table->string('phone')->required();
            $table->string('vat')->required();
            $table->string('type')->nullable();
            $table->integer('country_id')->unsigned()->index();
            $table->integer('language_id')->unsigned()->index();
            $table->integer('admin')->unsigned()->index();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('admin')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
