<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();  // Identifiant unique (auto-incrémenté)
            $table->unsignedBigInteger('sender_id');  // ID de l'expéditeur (étudiant ou tuteur)
            $table->unsignedBigInteger('receiver_id'); // ID du destinataire (étudiant ou tuteur)
            $table->text('message');   // Le message
            $table->timestamp('sent_at')->useCurrent();  // Heure d'envoi, par défaut la date actuelle

            // Définir les clés étrangères
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps(); // Pour les colonnes created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
