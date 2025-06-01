<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStatusInRisksTable extends Migration
{
    public function up()
    {
        Schema::table('risks', function (Blueprint $table) {
            // If status is an ENUM, update it
            \DB::statement("ALTER TABLE risks MODIFY COLUMN status ENUM('pending', 'in_progress', 'resolved', 'unresolved') DEFAULT 'pending'");
        });
    }

    public function down()
    {
        Schema::table('risks', function (Blueprint $table) {
            // Revert to original ENUM values
            \DB::statement("ALTER TABLE risks MODIFY COLUMN status ENUM('pending', 'resolved') DEFAULT 'pending'");
        });
    }
}