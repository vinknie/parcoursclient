<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Verbatim;
use App\Models\Dialogue;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EventController extends Controller
{
    public function createEvent()
{
    $getCategory = Category::orderBy('position')->get();
    $events = Event::paginate(10);
    return view('admin.createEvent', compact('getCategory', 'events'));
}

    public function storeEvent(Request $request){

        $validation = $request->validate([
            'name' => 'required|max:255',
        ]);

        $event = new Event;
        $event->name  = $request->name;

        $event->save();

        return redirect()->back()->with('success', 'Event created successfully.');

    }

    public function updateEvent(Request $request, $id)
    {
        $validation = $request->validate([
            'name' => 'required|max:255',
        ]);
    
        $event = Event::findOrFail($id);
        $event->name = $request->name;
        $event->save();
    
        return redirect()->back()->with('success_update', 'Événement modifié avec succès.');
    }
    
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
    
        return redirect()->back()->with('success_delete', 'Événement supprimé avec succès.');
    }


}