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
    $getCategory = Category::where('id_user', Auth::user()->id)->get();
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
    
        return response()->json(['success' => true]);
    }
    

}