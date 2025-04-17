<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10">
    <div class="container px-6 mx-auto space-y-6">

        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Kolom 1 -->
            <div class="space-y-6">
                <!-- Jam Digital -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl shadow-xl p-6 text-center overflow-hidden">
                    <p class="text-5xl md:text-6xl font-bold tracking-widest truncate" wire:poll.1s="updateClock">
                        {{ now()->format('H:i') }}
                    </p>
                    <p class="mt-2 text-base md:text-lg font-light">
                        {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>


                <!-- Sambutan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <p class="text-lg md:text-xl text-gray-700 dark:text-gray-200 font-medium">
                        Selamat datang di halaman dashboard,
                        <span
                            class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ Auth::user()->name }}</span>!
                    </p>
                </div>

                <!-- Total User -->
                @if ($totalUsers)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class='bx bxs-user text-3xl text-white'></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 font-medium">Total User</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kolom 2 & 3: Kalender -->
            <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                @livewire('google-calendar')
            </div>

        </div>
    </div>
</div>
