<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role_user_group', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('user_group_id')->constrained('user_groups')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['role_id', 'user_group_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_user_group');
    }
};
