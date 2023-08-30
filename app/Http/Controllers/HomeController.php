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
          // Joindre la table "category_event" pour filtrer les événements liés à une catégorie
    $events = Event::join('category-event', 'event.id_event', '=', 'category-event.id_event')
    ->select('event.*')
    ->whereNotNull('category-event.id_category') // Filtrer les événements liés à une catégorie
    ->groupBy('event.name') // Regrouper les événements par leur nom
    ->get();

    
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

public function updateVote(Request $request, $id_verbatim, $voteType)
{
    $validVoteTypes = ['positif', 'neutre', 'negatif'];

    if (!in_array($voteType, $validVoteTypes)) {
        return redirect()->back()->with('error', 'Type de vote non valide.');
    }

    $verbatim = Verbatim::findOrFail($id_verbatim);

    $userId = auth()->user()->id;

    $existingVote = UserVote::where('user_id', $userId)
                             ->where('verbatim_id', $id_verbatim)
                             ->first();

    if ($existingVote) {
        return redirect()->back()->with('error', 'Vous avez déjà voté pour ce verbatim.');
    }

    UserVote::create([
        'user_id' => $userId,
        'verbatim_id' => $id_verbatim,
        'vote_type' => $voteType,
    ]);

    $verbatim->increment($voteType);

    return redirect()->back();
}

public function updatepositif(Request $request, $id_verbatim)
{
    return $this->updateVote($request, $id_verbatim, 'positif');
}

public function updateneutre(Request $request, $id_verbatim)
{
    return $this->updateVote($request, $id_verbatim, 'neutre');
}

public function updatenegatif(Request $request, $id_verbatim)
{
    return $this->updateVote($request, $id_verbatim, 'negatif');
}


}
