<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Session;



class GoogleCalendar extends Component
{
    public $events = [];

    public function mount(GoogleCalendarService $googleService)
    {
        if (Session::has('google_calendar_token')) {
            $googleService->setAccessToken(Session::get('google_calendar_token'));
            $this->events = $googleService->getCalendarEvents();
        }
    }
    public function render()
    {
        return view('livewire.google-calendar');
    }
}
