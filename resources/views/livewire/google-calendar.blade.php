<div>
   <div class="bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Google Calendar Events</h2>

    @if($events)
        <ul class="list-disc pl-5 space-y-2">
            @foreach ($events as $event)
                <li class="text-gray-700">
                    <span class="font-semibold">{{ $event->getSummary() }}</span> -
                    <span class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($event->start->dateTime ?: $event->start->date)->format('d M Y H:i') }}
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No events found.</p>
    @endif
</div>

</div>
