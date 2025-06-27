<x-layout-hod>
    <x-slot:heading>Monitor Task</x-slot:heading>
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
                <button
                    type="submit"
                    class="bg-blue-700 hover:bg-blue-900 text-white font-bold px-5 py-2 rounded-md flex items-center gap-2 shadow-lg border border-blue-900"
                >
                    <i class="bi bi-search"></i>
                    Search
                </button>
            </div>
        </form>

        <!-- Task Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($tasks as $task)
                <div onclick="window.location.href='{{ route('hod.monitorTaskDetail', $task['id']) }}'" class="relative cursor-pointer bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition transform hover:scale-[1.01] group">
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

                    <!-- Assigned To -->
                    <div class="mt-4 flex items-center gap-3">
                        <img src="{{ isset($task['assignedTo']->path) && $task['assignedTo']->path ? asset('storage/' . $task['assignedTo']->path) : asset('logo/kpm.png') }}" alt="Profile" class="w-10 h-10 rounded-full" />
                        <div>
                            <div class="text-sm font-semibold">{{ $task['assignedTo']->name ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $task['assignedTo']->role ?? '-' }}</div>
                        </div>
                    </div>

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

                    @php
                        $isOverdue = \Carbon\Carbon::parse($task['dueDate'])->isPast() && $task['status'] !== 'Completed';
                    @endphp
                    @if($isOverdue)
                        <div class="mb-3 mt-3 p-3 bg-red-100 border border-red-400 text-red-700 rounded flex items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill text-red-600 text-lg"></i>
                            <span class="font-semibold">Overdue!</span>
                            <span class="text-sm">This task was due on {{ \Carbon\Carbon::parse($task['dueDate'])->format('d M Y') }} and is not completed.</span>
                        </div>
                    @endif

{{--                    <!-- Action Buttons (placeholders) -->--}}
{{--                    <div class="mt-6 flex justify-between">--}}
{{--                        <div class="space-x-2">--}}
{{--                            <button type="button" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">--}}
{{--                                <i class="bi bi-pencil-square font-bold text-xl"></i> Edit--}}
{{--                            </button>--}}
{{--                            <button type="button" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">--}}
{{--                                <i class="bi bi-trash font-bold text-xl"></i> Delete--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        @if($task['status']==='Completed')--}}
{{--                            <div class="space-x-2">--}}
{{--                                <a href="">--}}
{{--                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"><i class="bi bi-check2-circle"></i> Verified</button>--}}
{{--                                </a>--}}
{{--                                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"><i class="bi bi-x-circle"></i> Not Valid</button>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
                </div>
            @empty
                <div class="col-span-3 text-center text-slate-500 py-12">No tasks found for your department.</div>
            @endforelse
        </div>
    </div>
</x-layout-hod>
