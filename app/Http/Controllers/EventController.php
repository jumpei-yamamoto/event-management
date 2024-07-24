<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\UniqueUrl;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request, $url)
    {
        $uniqueUrl = UniqueUrl::where('url', $url)->firstOrFail();
        
        $month = $request->input('month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $month);

        $events = Event::where('unique_url_id', $uniqueUrl->id)
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->orderBy('date')
            ->get();

        return view('events.index', compact('events', 'url', 'month'));
    }

    public function store(Request $request, $url)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $uniqueUrl = UniqueUrl::where('url', $url)->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1|gte:min_participants',
        ]);

        $validatedData['unique_url_id'] = $uniqueUrl->id;
        Event::create($validatedData);

        return redirect()->route('events.index', $url)->with('success', 'イベントが作成されました。');
    }

    public function participate($url, $eventId)
    {
        $event = Event::findOrFail($eventId);
        
        // Check if the user is already a participant
        if ($event->participants()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('message', 'このイベントにはすでに参加しています。');
        }

        // Add the user as a participant
        EventParticipant::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('message', 'イベントに参加しました。');
    }

    public function show($url, Event $event)
    {
        return response()->json($event);
    }
}