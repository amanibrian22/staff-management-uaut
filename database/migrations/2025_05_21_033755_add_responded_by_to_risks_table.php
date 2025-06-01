<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRespondedByToRisksTable extends Migration
{
    public function up()
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->foreignId('responded_by')->nullable()->constrained('users')->onDelete('set null')->after('reported_by');
        });
    }

    public function down()
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropForeign(['responded_by']);
            $table->dropColumn('responded_by');
        });
    }
}