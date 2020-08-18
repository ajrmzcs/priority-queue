<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriorityJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priority_jobs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('submitter_id');
            $table->text('processor_id')->nullable();
            $table->enum('priority', ['high', 'low']);
            $table->enum('command', ['command_1', 'command_2']);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('priority_jobs');
    }
}
