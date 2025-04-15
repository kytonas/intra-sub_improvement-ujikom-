<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Kalender</h2>
        <div id="calendar" class="relative" z-10></div>
        <p class="text-gray-300"><small>Powered by Google</small></p>

    </div>

    <!-- Modal -->
    <div id="event-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg w-1/3 relative">
            <!-- Tombol Close "X" -->
            <button onclick="closeModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Judul -->
            <!-- Judul + Status -->
            <h2 class="text-lg font-bold flex items-center space-x-2">
                <span id="modal-title"></span>
                <span id="modal-status" class="px-2 py-1 text-sm font-semibold rounded-md"
                    style="background-color: gray; color: white;">
                </span>
            </h2>


            <!-- Deskripsi -->
            <p class="mt-2"><strong>Deskripsi : </strong></p>
            <p id="modal-description" class="mt-2 text-gray-700 dark:text-gray-300"></p>

            <!-- Nama Proyek -->
            <p class="mt-2"><strong>Project : </strong> <span id="modal-project"></span></p>

            <!-- Responsible User -->
            <p class="mt-2"><strong>Responsible : </strong> <span id="modal-responsible"></span></p>

            <!-- Tanggal Deadline -->
            <p class="mt-2"><strong>Deadline : </strong> <span id="modal-deadline"></span></p>




            <div role="alert" class="alert bg-red-400 text-black mt-4" id="modal-warning-deadline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current inline-block"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Warning : Task ini sudah mencapai deadline</span>
            </div>

            <!-- Peringatan H-1 Deadline -->
            <div role="alert" class="alert bg-yellow-300 text-black mt-4" id="modal-warning-soon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current inline-block"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span id="modal-warning-text"></span>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id', // Bahasa Indonesia
                initialView: 'dayGridMonth',
                events: {!! $eventsJson !!},
                eventClick: function(info) {
                    let today = new Date();
                    let eventDate = new Date(info.event.end);
                    eventDate.setDate(eventDate.getDate() - 1);
                    let diffMs = eventDate - today;
                    let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                    let diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                    let diffMinutes = Math.floor(diffMs / (1000 * 60));
                    let options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    let deadlineFormatted = eventDate.toLocaleDateString('id-ID', options);


                    document.getElementById('modal-title').innerText = info.event.title;
                    document.getElementById('modal-description').innerHTML = info.event.extendedProps
                        .description || 'Tidak ada deskripsi';
                    document.getElementById('modal-deadline').innerText = deadlineFormatted;
                    document.getElementById('modal-status').innerText = info.event.extendedProps
                        .status || 'Tanpa Status';
                    document.getElementById('modal-project').innerText = info.event.extendedProps
                        .project || 'Tanpa Proyek';
                    document.getElementById('modal-responsible').innerText = info.event.extendedProps
                        .responsible || 'Tidak Diketahui';


                    // Reset semua peringatan dulu
                    document.getElementById('modal-warning-deadline').classList.add('hidden');
                    document.getElementById('modal-warning-soon').classList.add('hidden');

                    // Cek jika event sudah lewat deadline
                    if (eventDate < today) {
                        document.getElementById('modal-warning-deadline').classList.remove('hidden');
                    }
                    // Cek jika deadline akan datang dalam 24 jam
                    else if (diffDays < 1) {
                        let warningText = `Warning: Task ini akan mencapai deadline dalam `;

                        if (diffHours >= 1) {
                            warningText += `${diffHours} jam dari sekarang`;
                        } else if (diffMinutes > 0) {
                            warningText += `${diffMinutes} menit dari sekarang`;
                        } else {
                            warningText += `beberapa saat lagi`;
                        }

                        document.getElementById('modal-warning-text').innerText = warningText;
                        document.getElementById('modal-warning-soon').classList.remove('hidden');
                    }

                    document.getElementById('event-modal').classList.remove('hidden');
                },
                eventDidMount: function(info) {
                    let today = new Date();
                    let eventDate = new Date(info.event.end);
                    eventDate.setDate(eventDate.getDate() - 1);
                    let diffMs = eventDate - today;
                    let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

                    // Default warna hijau (deadline masih jauh)
                    let bgColor = 'green';
                    let textColor = 'white'; // Default untuk hijau

                    if (diffDays < 1 && diffDays >= 0) {
                        bgColor = 'orange'; // H-1 deadline (mendekati deadline)
                        textColor = 'black';
                    } else if (diffDays < 0) {
                        bgColor = 'red'; // Sudah mencapai atau melewati deadline
                        textColor = 'white'; // Paksa putih agar kontras dengan merah
                    }

                    info.el.style.backgroundColor = bgColor;
                    info.el.style.setProperty('color', textColor, 'important'); // Paksa warna teks
                    info.el.style.padding = '4px'; // Tambah padding agar teks tidak terlalu mepet
                    info.el.style.borderRadius = '4px'; // Agar lebih rapi
                    info.el.style.overflow = 'hidden'; // Supaya teks tidak keluar batas
                    info.el.style.textOverflow =
                        'ellipsis'; // Jika teks terlalu panjang, tampilkan "..."
                    info.el.style.whiteSpace = 'nowrap'; // Supaya tetap dalam satu baris
                    info.el.style.display = 'flex'; // Supaya teks bisa sejajar dengan padding yang baik
                    info.el.style.alignItems = 'center'; // Teks berada di tengah secara vertikal
                    info.el.style.justifyContent = 'center'; // Teks berada di tengah secara horizontal
                }


            });
            calendar.render();
        });

        function closeModal() {
            document.getElementById('event-modal').classList.add('hidden');
        }
    </script>
</div>
