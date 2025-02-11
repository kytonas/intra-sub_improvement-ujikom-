<div>

    {{-- content --}}
    <div class="container px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        <div class="grid grid-cols-3 gap-4">
            <!-- Kolom 1: Jam Digital, Sambutan, dan Total User -->
            <div class="col-span-1 space-y-4">
                <!-- Jam Digital -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                    <p class="text-5xl font-extrabold text-gray-800 dark:text-white" wire:poll.1s="updateClock">
                        {{ now()->format('H:i:s') }}
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>

                <!-- Sambutan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <p class="text-xl text-gray-800 dark:text-gray-200">
                        Selamat datang di halaman dashboard,
                        <span class="text-blue-500 font-semibold">{{ Auth::user()->name }}</span>!
                    </p>
                </div>

                <!-- Total User -->
                @if ($totalUsers)
                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-center w-14 h-14 bg-blue-500 rounded-full text-white">
                            <i class='bx bxs-user text-3xl'></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-medium text-gray-800 dark:text-gray-300">Total User</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kolom 2: Google Calendar -->
            <div class="col-span-2">
                @livewire('google-calendar')
            </div>
        </div>
    </div>


</div>
