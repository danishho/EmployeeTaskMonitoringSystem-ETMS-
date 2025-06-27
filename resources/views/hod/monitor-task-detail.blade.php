<x-layout-hod>
    <x-slot:heading>Task Details</x-slot:heading>
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif
    <div class="p-6 space-y-10" x-data="modalHandler">
        <!-- Task Details Section -->
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

            <!-- Assigned User -->
            @if($task->assignedTo)
            <div class="mt-6 border-t pt-6">
                <label class="font-medium text-slate-700">Assigned To</label>
                <div class="flex items-center gap-4 mt-2">
                    <img src="{{ isset($task->assignedTo->path) && $task->assignedTo->path ? asset('storage/' . $task->assignedTo->path) : asset('logo/kpm.png') }}" class="w-10 h-10 rounded-full" alt="User Avatar">
                    <div>
                        <p class="font-medium text-slate-800">{{ $task->assignedTo->name }}</p>
                        <small class="text-slate-500">{{ ucfirst($task->assignedTo->role) }}</small>
                    </div>
                </div>
            </div>
            @endif

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

{{--
--}}

                <button @click="openModal = 'comment-task'" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">
                    <i class="bi bi-chat-left-text"></i>
                    <span>Comment</span>
                </button>

{{--                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">--}}
{{--                    <i class="bi bi-pencil-square"></i>--}}
{{--                    <span>Update</span>--}}
{{--                </button>--}}
                <button  @click="openModal = 'delete-task'" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow-sm flex items-center gap-2">
                    <i class="bi bi-trash"></i>
                    <span>Delete</span>
                </button>
            </div>

            <!-- Delete Confirmation Modal -->
            <div
                x-show="openModal === 'delete-task'"
                x-transition
                class="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
            >
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                    <h3 class="text-lg font-semibold mb-4 text-red-700">Delete Task</h3>
                    <p class="mb-4">Are you sure you want to delete <span class="font-bold">{{ $task->title }}</span>?</p>
                    <form method="POST" action="{{ route('hod.deleteTask', $task->id) }}">
                        @csrf
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="openModal = null" class="px-4 py-2 rounded bg-slate-200 hover:bg-slate-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        <!-- Update Password Modal -->

        <div
            x-show="openModal === 'comment-task'"
            x-transition
            class="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
        >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                <h3 class="text-lg font-semibold mb-4">Comment on Task</h3>
                <form method="POST" action="{{route('hod.commentTask', ['task' => $task->id]) }}">

                    @csrf
                    <textarea
                        name="message"
                        required
                        class="w-full border border-slate-300 rounded-md px-4 py-2 mb-4"
                        rows="4"
                        placeholder="Enter your comment on the task progress"
                    >{{ $task->message}}</textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openModal = null" class="px-4 py-2 rounded bg-slate-200 hover:bg-slate-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-700">Comment</button>
                    </div>
                </form>
            </div>
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

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('modalHandler', () => ({
                openModal: null
            }));
        });
    </script>
</x-layout-hod>
