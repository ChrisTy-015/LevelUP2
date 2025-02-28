<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {
        // Charger tous les utilisateurs avec leurs matières
        $users = User::with('subjects')->get();
        
        // Charger toutes les matières disponibles
        $subjects = Subject::all();

        return view('levelup.index', compact('users', 'subjects'));
    }

    public function filter(Request $request)
    {
        // Récupérer les utilisateurs filtrés
        $users = User::query();

        if ($request->filled('subject')) {
            $users = $users->whereHas('subjects', function ($query) use ($request) {
                $query->where('subjects.id', $request->subject);
            });
        }

        $users = $users->get();

        // Charger toutes les matières disponibles
        $subjects = Subject::all();

        return view('levelup.index', compact('users', 'subjects'));
    }
}
