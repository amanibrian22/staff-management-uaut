<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrgencyToRisksTable extends Migration
{
    public function up()
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->string('urgency')->default('medium');
        });
    }

    public function down()
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropColumn('urgency');
        });
    }
}