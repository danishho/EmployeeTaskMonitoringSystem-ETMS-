<x-layout-staff>
    <x-slot:heading>Task Details</x-slot:heading>
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif
    <div class="p-6 space-y-10">
        <!-- Task Details Section -->
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4">Task Details</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="font-medium text-slate-700">Title</label>
                    <p class="text-slate-800">{{ $task->title }}</p>
                </div>
                <div>
                    <label class="font-medium text-slate-700">Due Date</label>
                    <p class="text-slate-800">{{ \Carbon\Carbon::parse($task->dueDate)->format('d M Y') }}</p>
                </div>
                <div>
                    <label class="font-medium text-slate-700">Priority</label>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                        @if(strtolower($task->priority) == 'high') bg-red-100 text-red-700
                        @elseif(strtolower($task->priority) == 'medium') bg-yellow-100 text-yellow-700
                        @else bg-green-100 text-green-700
                        @endif">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>
                <div>
                    <label class="font-medium text-slate-700">Status</label>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                        @if($task->status === 'Completed') bg-green-100 text-green-700
                        @elseif($task->status === 'In Progress') bg-yellow-100 text-yellow-700
                        @else bg-slate-100 text-slate-700
                        @endif">
                        {{ $task->status }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <label class="font-medium text-slate-700">Description</label>
                    <p class="text-slate-800">{{ $task->description }}</p>
                </div>
                @if($task->message)
                <div class="md:col-span-2">
                    <label class="font-medium text-slate-700">Message</label>
                    <p class="text-slate-800">{{ $task->message }}</p>
                </div>
                @endif
            </div>


            <!-- Progress Summary -->
            <div class="mt-6">
                <label class="font-medium text-slate-700">Overall Progress</label>
                <div class="w-full bg-slate-200 rounded-full h-4 mt-1">
                    <div class="bg-blue-600 h-4 rounded-full text-xs text-white text-center" style="width: {{ $overallProgress }}%">{{ $overallProgress }}%</div>
                </div>
            </div>

            <!-- Attachments -->
            @if($task->attachments->isNotEmpty())
            <div class="mt-6">
                <label class="font-medium text-slate-700">Task Attachments</label>
                <ul class="mt-2 space-y-2">
                    @foreach($task->attachments as $attachment)
                    <li class="flex items-center justify-between p-2 border rounded hover:bg-slate-50">
                        <a href="{{ asset('storage/' . $attachment->filePath) }}" download="{{ $attachment->fileName }}" class="truncate pr-2">{{ $attachment->fileName }}</a>
                        <a href="{{ asset('storage/' . $attachment->filePath) }}" download="{{ $attachment->fileName }}">
                            <i class="bi bi-download text-blue-600 cursor-pointer"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif


            <!-- action Button -->
            <div class="mt-8 flex justify-end gap-3">
                @if($overallProgress != 100)
                    <a href="{{route('staff.updateProgress', $task->id)}}">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">
                            <i class="bi bi-arrow-repeat font-bold text-xl"></i>
                            <span>Update Progress</span>
                        </button>
                    </a>
                    <a href="{{route('staff.TaskMarkComplete', $task->id)}}">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">
                            <i class="bi bi-check-circle font-bold text-xl"></i>
                            <span>Mark as Complete</span>
                        </button>
                    </a>
                @endif




{{--                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">--}}
{{--                    <i class="bi bi-pencil-square"></i>--}}
{{--                    <span>Update</span>--}}
{{--                </button>--}}
{{--                <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">--}}
{{--                    <i class="bi bi-trash"></i>--}}
{{--                    <span>Delete</span>--}}
{{--                </button>--}}
            </div>

        </div>

        <!-- Progress Details Section -->
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4">Progress Updates</h2>
            <div class="space-y-6">
                @forelse($task->task_progresses as $progress)
                <div class="border p-4 rounded-lg shadow-sm bg-slate-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-slate-800">{{ $progress->title }}</p>
                            <p class="text-slate-600 mt-1">{{ $progress->description }}</p>
                            <p class="text-xs text-slate-500 mt-2">Updated on: {{ $progress->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium whitespace-nowrap">{{ $progress->progressLevel }}% Complete</span>
                    </div>
                    @if($progress->attachments->isNotEmpty())
                    <div class="mt-3">
                        <label class="text-slate-700 text-sm font-medium">Attachments</label>
                        <ul class="mt-1 space-y-1">
                            @foreach($progress->attachments as $attachment)
                            <li class="flex items-center justify-between p-2 bg-white border rounded">
                                <a href="{{ asset('storage/' . $attachment->filePath) }}" download="{{ $attachment->fileName }}" class="truncate pr-2">{{ $attachment->fileName }}</a>
                                <a href="{{ asset('storage/' . $attachment->filePath) }}" download="{{ $attachment->fileName }}">
                                    <i class="bi bi-download text-blue-600 cursor-pointer"></i>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-slate-500 text-center py-4">No progress updates have been submitted for this task yet.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-layout-staff>
