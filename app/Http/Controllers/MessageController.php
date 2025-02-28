<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        // Validation des données
        $request->validate([
            'message' => 'required|string',
            'recipient_id' => 'required|integer|exists:users,id',
        ]);

        // Logique pour envoyer le message
        // Exemple : enregistrer le message dans une table
        \App\Models\Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->input('recipient_id'),
            'message' => $request->input('message'),
        ]);

        // Retourner une réponse
        return back()->with('success', 'Message envoyé avec succès !');
    }
}
