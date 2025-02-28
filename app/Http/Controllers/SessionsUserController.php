<?php

namespace App\Http\Controllers;

use App\Models\SessionsUser;
use Illuminate\Http\Request;

class SessionsUserController extends Controller
{
    public function reserve(Request $request)
    {
        // Récupération des données
        $userId = $request->input('user_id');
        $sessionDate = $request->input('session_date');

        // Logique pour enregistrer la réservation (par exemple, sauvegarde en base de données)
        $reservation = new SessionsUser();
        $reservation->user_id = $userId;
        $reservation->date = $sessionDate;
        $reservation->save();

        // Redirection ou message de succès
        return redirect()->route('levelup')->with('success', 'Session réservée avec succès!');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date|after:now',
        ]);

        // Logique de sauvegarde de la réservation
        SessionsUser::create($validatedData);

        return redirect()->back()->with('success', 'Session réservée avec succès !');
    }

}
