<x-layout-staff>
    <x-slot:heading>Dashboard</x-slot:heading>
    <div class="p-6 space-y-6">
        <!-- Total Task Full Width Card -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-xl shadow-lg flex items-center gap-5 text-white">
            <div class="text-5xl">
                <i class="bi bi-clipboard-data"></i>
            </div>
            <div>
                <div class="text-sm uppercase">Total Task</div>
                <div class="text-3xl font-bold">{{ $totalTask }}</div>
            </div>
        </div>

        <!-- Grid of 3 Smaller Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-check-circle text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">Completed</div>
                    <div class="text-2xl font-bold">{{ $completedTask }}</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-arrow-repeat text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">In Progress</div>
                    <div class="text-2xl font-bold">{{ $inProgressTask }}</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-pink-600 p-5 rounded-xl shadow-md text-white flex items-center gap-4">
                <i class="bi bi-hourglass-split text-4xl"></i>
                <div>
                    <div class="text-sm uppercase">Not Started</div>
                    <div class="text-2xl font-bold">{{ $notStartedTask }}</div>
                </div>
            </div>
        </div>
    </div>
</x-layout-staff>


