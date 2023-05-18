<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ikay\TheharvesterService\Models\Theharvester;

return new class extends Migration
{
    public function up()
    {
        Schema::create('theharvesters', function (Blueprint $table) {
            $table->id();
             $table->foreignIdFor(config('theharvester-service.model'))->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('container');
            $table->string('domain');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('theharvester_containers', function (Blueprint $table) {
            $table->id();
            $table->string('container_id')->index();
            $table->foreignIdFor(Theharvester::class)->index()->constrained();
            $table->integer('ip');
            $table->integer('email');
            $table->integer('host');
            $table->longText('log');
            $table->integer('operation_time')->default(0);
            $table->timestamps();
        });

         Schema::create('theharvester_eventual_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Theharvester::class)->index()->constrained();
            $table->longText('message');
            $table->string('code');
            $table->string('file');
            $table->string('line');
            $table->text('trace');
            $table->timestamps();
        });

    }

     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theharvester_eventual_errors');
        Schema::dropIfExists('theharvester_containers');
        Schema::dropIfExists('theharvesters');
    }
};
