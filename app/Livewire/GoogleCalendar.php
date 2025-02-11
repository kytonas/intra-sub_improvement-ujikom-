<?php
namespace App\Livewire;

use App\Models\Tasks;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class GoogleCalendar extends Component
{
    public $events = [];

    public function mount(GoogleCalendarService $googleService)
    {
        // Ambil event dari Google Calendar jika ada token
        if (Session::has('google_calendar_token')) {
            $googleService->setAccessToken(Session::get('google_calendar_token'));
            $googleEvents = collect($googleService->getCalendarEvents())->map(function ($event) {
                return [
                    'title'       => $event->getSummary(),
                    'start'       => $event->getStart()->getDateTime() ?? $event->getStart()->getDate(),
                    'end'         => $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate(),
                    'description' => $event->getDescription() ?? '',
                ];
            })->toArray();
        } else {
            $googleEvents = [];
        }

        // Ambil task dari database
        $taskEvents = Tasks::whereNotNull('end_date')->with(['project', 'status'])->get()->map(function ($task) {
            return [
                'title'       => $task->name, // Tambahkan status
                'start'       => $task->end_date,
                'end'         => $task->end_date,
                'description' => $task->content,
                'id'          => $task->id,
                'project'     => $task->project->name ?? 'Tanpa Proyek',
                'status'      => $task->status->name ?? 'Tanpa Status', // Tambahkan status
            ];
        })->toArray();

        // Gabungkan event dari Google Calendar dan Task
        $this->events = array_merge($googleEvents, $taskEvents);
    }

    public function render()
    {
        return view('livewire.google-calendar', [
            'eventsJson' => json_encode($this->events),
        ]);
    }
}
