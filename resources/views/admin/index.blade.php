<x-layout>
    <x-slot:heading>DASHBOARD</x-slot:heading>
    <!-- Dashboard Cards Layout for $slot -->
    <div class="p-6 space-y-6">
        <!-- Total Users Full Width Card -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-xl shadow-lg flex items-center gap-5 text-white">
            <div class="text-5xl">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="text-sm uppercase">Total Users</div>
                <div class="text-3xl font-bold">{{ $totalUsers }}</div>
            </div>
        </div>

        <!-- Grid of 4 Smaller Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="bg-gradient-to-r from-pink-500 to-rose-600 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-person-gear text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">Total Admin</div>
                    <div class="text-2xl font-bold">{{ $totalAdmin }}</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-person-badge text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">Total HOD</div>
                    <div class="text-2xl font-bold">{{ $totalHod }}</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-teal-600 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-person-video2 text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">Total Lecturer</div>
                    <div class="text-2xl font-bold">{{ $totalLecturer }}</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-fuchsia-600 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-person-workspace text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">Total Staff</div>
                    <div class="text-2xl font-bold">{{ $totalStaff }}</div>
                </div>
            </div>
        </div>
    </div>


</x-layout>
