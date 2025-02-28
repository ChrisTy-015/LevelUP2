<?
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur.
     */
    public function showProfile(Request $request): View
    {
        // Récupérer l'utilisateur connecté avec ses relations
        $user = Auth::user()->load(['subjects', 'course']);

        return view('profile.show', [
            'user' => $user
        ]);
    }

}