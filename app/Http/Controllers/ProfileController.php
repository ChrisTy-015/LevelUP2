<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Récupérer tous les cours disponibles
        $courses = Course::all();

        // Récupérer toutes les matières disponibles
        $subjects = Subject::all(); // Récupération de toutes les matières

        // Passer les variables à la vue, y compris l'utilisateur authentifié
        return view('profile.edit', [
            'user' => $request->user(), // L'utilisateur connecté
            'courses' => $courses,      // Les cours disponibles
            'subjects' => $subjects,    // Les matières disponibles
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validation des données
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'status' => 'required|in:Mentee,Mentor,Les deux',
        ]);

        $user = $request->user();

        // Mise à jour des informations de base du profil
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Mise à jour du statut et de la formation
        $user->status = $request->status;
        $user->course_id = $request->course_id;
        
        // Sauvegarde des changements de base
        $user->save();

        // Synchronisation des matières sélectionnées
        $user->subjects()->sync($request->subjects);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show the profile edit form with the user courses and associated subjects.
     */

    public function showEditForm()
    {
        $user = auth()->user();

        // Récupérez toutes les matières disponibles, indépendamment des cours
        $subjects = Subject::all(); // Récupération de toutes les matières

        // Récupérez toutes les formations
        $courses = Course::all();

        return view('profile.edit', compact('courses', 'subjects'));
    }

    public function updateProfilePhoto(Request $request)
    {
        try {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();

            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Enregistrer la nouvelle photo
            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            // Mettre à jour le chemin de la photo dans la base de données
            $user->profile_photo = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo de profil mise à jour avec succès',
                'path' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la photo : ' . $e->getMessage()
            ], 422);
        }
    }
}
