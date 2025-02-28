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
       // Récupérer tous les utilisateurs
    $users = User::all();

    // Récupérer toutes les matières disponibles pour le filtre
    $subjects = Subject::all();

    // Passer les utilisateurs et les matières à la vue
    return view('levelup.index', [
        'users' => $users,
        'subjects' => $subjects
    ]);
    }

}