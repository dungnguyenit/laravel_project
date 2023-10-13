<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // DB::statement("UPDATE posts SET created_at = created_at + INTERVAL 7 HOUR");
            $table->id(); // id (primary key)
            $table->unsignedBigInteger('user_id'); // user_id (foreign key referencing the users table)
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('content'); // content
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
