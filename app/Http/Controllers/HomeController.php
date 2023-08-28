<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventUsers;
use App\Models\Category;
use App\Models\Verbatim;
use App\Models\UserVote;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $events = Event::all();

        return view('accueil', compact('user', 'events'));
    }

    public function submitEvent(Request $request)
{
    $userId = Auth::id();
    $eventId = $request->input('event');

    // Store the user's participation in the event
    $eventuser = new EventUsers();
    $eventuser->id_user = Auth::user()->id;
    $eventuser->id_event = $eventId;
    
    $eventuser->save();

    // Redirect the user to a success page or another route
    return redirect()->route('satisfaction', ['eventId' => $eventId]);
}
public function satisfaction()
{
    $eventId = request('eventId');

    // Récupérer les catégories liées à l'événement
    $categories = Category::join('category-event', 'category.id_category', '=', 'category-event.id_category')
        ->where('category-event.id_event', $eventId)
        ->get();

    // Récupérer les verbatims liés aux catégories de l'événement, triés par position
    $verbatimsByCategory = [];

    foreach ($categories as $category) {
        $verbatims = Verbatim::where('id_category', $category->id_category)
            ->orderBy('position')
            ->get();
        $verbatimsByCategory[$category->id_category] = $verbatims;
    }

    // Passer les catégories et les verbatims à la vue
    return view('satisfaction', compact('categories', 'verbatimsByCategory'));
}



public function updatepositif(Request $request, $id_verbatim)
{
    
    $verbatim = Verbatim::findOrFail($id_verbatim);
    $userId = auth()->user()->id;

    $existingVote = UserVote::where('user_id', $userId)
                             ->where('verbatim_id', $id_verbatim)
                             ->first();

    if ($existingVote) {
        // L'utilisateur a déjà voté, peut-être vous voulez le rediriger vers une page d'erreur
        return redirect()->back()->with('error', 'Vous avez déjà voté pour ce verbatim.');
    }

    // L'utilisateur n'a pas encore voté, enregistrez le vote
    UserVote::create([
        'user_id' => $userId,
        'verbatim_id' => $id_verbatim,
        'vote_type' => 'positif',
    ]);

    // Mettez à jour le compteur positif dans le verbatim
    $verbatim->increment('positif');
    

    return redirect()->back();
}

public function updateneutre(Request $request, $id_verbatim)
{
    $verbatim = Verbatim::findOrFail($id_verbatim);

    $userId = auth()->user()->id;

    $existingVote = UserVote::where('user_id', $userId)
                             ->where('verbatim_id', $id_verbatim)
                             ->first();

    if ($existingVote) {
        // L'utilisateur a déjà voté, peut-être vous voulez le rediriger vers une page d'erreur
        return redirect()->back()->with('error', 'Vous avez déjà voté pour ce verbatim.');
    }

    // L'utilisateur n'a pas encore voté, enregistrez le vote
    UserVote::create([
        'user_id' => $userId,
        'verbatim_id' => $id_verbatim,
        'vote_type' => 'neutre',
    ]);

    // Mettez à jour le compteur positif dans le verbatim
    $verbatim->increment('neutre');

    return redirect()->back();
}

public function updatenegatif(Request $request, $id_verbatim)
{
    $verbatim = Verbatim::findOrFail($id_verbatim);

    $userId = auth()->user()->id;

    $existingVote = UserVote::where('user_id', $userId)
                             ->where('verbatim_id', $id_verbatim)
                             ->first();

    if ($existingVote) {
        // L'utilisateur a déjà voté, peut-être vous voulez le rediriger vers une page d'erreur
        return redirect()->back()->with('error', 'Vous avez déjà voté pour ce verbatim.');
    }

    // L'utilisateur n'a pas encore voté, enregistrez le vote
    UserVote::create([
        'user_id' => $userId,
        'verbatim_id' => $id_verbatim,
        'vote_type' => 'negatif',
    ]);

    // Mettez à jour le compteur positif dans le verbatim
    $verbatim->increment('negatif');

    return redirect()->back();
}
}
