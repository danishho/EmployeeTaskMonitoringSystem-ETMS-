<x-layout-hod>
    <x-slot:heading>Dashboard</x-slot:heading>
    <div class="p-6 space-y-6">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="bi bi-people text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Employees</p>
                    <h2 class="text-2xl font-semibold">{{ $totalEmployees }}</h2>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="bi bi-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Completed Tasks</p>
                    <h2 class="text-2xl font-semibold">{{ $completedTasks }}</h2>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="bi bi-arrow-repeat text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">In Progress Tasks</p>
                    <h2 class="text-2xl font-semibold">{{ $inProgressTasks }}</h2>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <i class="bi bi-hourglass-split text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Not Started Tasks</p>
                    <h2 class="text-2xl font-semibold">{{ $notStartedTasks }}</h2>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4 text-slate-800 flex items-center gap-2">
                <i class="bi bi-clock-history"></i> Recent Activities
            </h2>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-center">
                            <p class="font-semibold">{{ $activity->task->title ?? 'Unknown Task' }}</p>
                            <span class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            {{ $activity->title }}
                            @if($activity->task && $activity->task->assignedTo)
                                by {{ $activity->task->assignedTo->name }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mb-1">{{ $activity->description }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $activity->progressLevel }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Progress: {{ $activity->progressLevel }}%</p>
                    </div>
                @empty
                    <div class="text-gray-500">No recent activities found.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout-hod>
