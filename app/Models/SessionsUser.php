<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class SessionsUser extends Model
{
    public function up()
{
    Schema::create('session_users', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->dateTime('reservation_date');
        $table->timestamps();
        
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
}
