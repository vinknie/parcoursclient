<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventUsers;
use App\Models\Category;
use App\Models\Verbatim;
use App\Models\UserVote;
use App\Models\CategoryEvent;

class ResultController extends Controller
{
    public function index()
    {
        $getCategory = Category::all();
        $getVerbatim = Verbatim::all();
          // Joindre la table "category_event" pour filtrer les événements liés à une catégorie
    $events = Event::join('category-event', 'event.id_event', '=', 'category-event.id_event')
    ->select('event.*')
    ->whereNotNull('category-event.id_category') // Filtrer les événements liés à une catégorie
    ->groupBy('event.name') // Regrouper les événements par leur nom
    ->get();

    
        return view('admin.result', compact('events','getCategory','getVerbatim'));
    }

    public function getCategories(Request $request)
{
    // Récupérer l'ID de l'événement à partir de la requête
    $eventId = $request->input('eventId');
    
    // Rechercher les catégories associées à l'événement dans la table category_event
    $categories = CategoryEvent::where('id_event', $eventId)
        ->join('category', 'category-event.id_category', '=', 'category.id_category')
        ->select('category.id_category', 'category.title')
        ->get();

    // Créer un tableau pour stocker les verbatims associés aux catégories
    $verbatimArray = [];

    // Parcourir les catégories et rechercher les verbatims correspondants
    foreach ($categories as $category) {
        // Rechercher les verbatims associés à cette catégorie dans la table verbatim
        $verbatims = Verbatim::where('id_category', $category->id_category)
        ->select('verbatim', 'positif', 'negatif') // Sélectionnez les colonnes positif et negatif
        ->get();

        // Ajouter les verbatims à notre tableau
        $verbatimArray[$category->title] = $verbatims;
    }

    // Retourner les verbatims au format JSON
    return response()->json($verbatimArray);
}

    


}
