<x-layout-staff>
    <x-slot:heading>Task</x-slot:heading>
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif
    <div class="p-6 space-y-6">
        <!-- Search & Filter -->
        <form method="GET" action="{{ route('hod.monitorTask') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-center">
            <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                <input type="text" name="search" value="{{ old('search', $search) }}" placeholder="Search by title or staff" class="px-4 py-2 border rounded-lg w-full md:w-64" />
                <select name="priority" class="px-4 py-2 border rounded-lg">
                    <option value="">All Priorities</option>
                    <option value="high" @if($priority==='high') selected @endif>High</option>
                    <option value="medium" @if($priority==='medium') selected @endif>Medium</option>
                    <option value="low" @if($priority==='low') selected @endif>Low</option>
                </select>
                <select name="sort" class="px-4 py-2 border rounded-lg">
                    <option value="">Sort by Due Date</option>
                    <option value="closest" @if($sort==='closest') selected @endif>Closest Due First</option>
                    <option value="farthest" @if($sort==='farthest') selected @endif>Farthest Due First</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Task Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($tasks as $task)
                <div onclick="window.location.href='{{ route('staff.TaskDetail', $task['id']) }}'" class="relative cursor-pointer bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition transform hover:scale-[1.01] group">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-slate-800">{{ $task['title'] }}</h2>
                        <span class="text-sm text-slate-500 font-bold">Due: {{ \Carbon\Carbon::parse($task['dueDate'])->format('d M Y') }}</span>
                    </div>
                    <p class="text-slate-600 mt-2">{{ $task['description'] }}</p>

                    <!-- Priority & Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 mt-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-slate-600">Priority:</span>
                            <span class="px-2 py-1 rounded text-white text-xs @if($task['priority']==='high') bg-red-500 @elseif($task['priority']==='medium') bg-yellow-500 @else bg-green-500 @endif">{{ ucfirst($task['priority']) }}</span>
                        </div>
                        <div class="flex items-center gap-2 mt-2 sm:mt-0">
                            <span class="font-semibold text-slate-600">Status:</span>
                            <span class="px-2 py-1 rounded text-white text-xs @if($task['status']==='Completed') bg-green-500 @elseif($task['status']==='In Progress') bg-yellow-500 @else bg-slate-400 @endif">{{ $task['status'] }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-slate-600 font-medium">
                            <span>Progress:</span>
                            <span>{{ $task['progressLevel'] }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-3 mt-1">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $task['progressLevel'] }}%"></div>
                        </div>
                    </div>

                    <!-- Message -->
                    @if($task['message'])
                        <div class="mt-4 text-slate-600">
                            <strong>Latest Message:</strong> {{ $task['message'] }}
                        </div>
                    @endif


                    <!-- Latest Progress -->
                    @if($task['latestProgressTitle'] || $task['latestProgressDescription'])
                        <div class="mt-4 text-sm text-slate-700">
                            <strong>Latest Progress:</strong>
                            {{ $task['latestProgressTitle']}} -
                            {{ $task['latestProgressDescription'] }}
                            @if($task['latestProgressDate'])
                                on {{ \Carbon\Carbon::parse($task['latestProgressDate'])->format('d M Y') }}
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons (placeholders) -->
                    @if($task['progressLevel'] != 100)
                        <div class="mt-6 flex justify-between">
                            <div class="space-x-2">
                                <!-- Update Progress Button -->
                                <a href="{{route('staff.updateProgress', $task['id'])}}">
                                    <button type="button" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                        <i class="bi bi-arrow-repeat font-bold text-xl"></i> Update Progress
                                    </button>
                                </a>


                                <!-- Mark as Complete Button -->
                                <button type="button" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                    <i class="bi bi-check-circle font-bold text-xl"></i> Complete
                                </button>
                            </div>

                        </div>
                    @endif

                </div>
            @empty
                <div class="col-span-3 text-center text-slate-500 py-12">No tasks found.</div>
            @endforelse
        </div>
    </div>

</x-layout-staff>
