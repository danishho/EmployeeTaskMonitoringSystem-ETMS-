<x-layout-hod>
    <x-slot:heading>Create Task</x-slot:heading>
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif
    <div class="p-8 space-y-8">
        <form action="{{route('hod.storeTask')}}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <!-- Form Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">Title</label>
                    <input type="text" name="title" class="block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 p-3" placeholder="Enter task title" required>
                    <x-input-error name="title"></x-input-error>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">Priority</label>
                    <select name="priority" class="block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 p-3">
                        <option value="High">High Priority</option>
                        <option value="Medium">Medium Priority</option>
                        <option value="Low">Low Priority</option>
                    </select>
                    <x-input-error name="priority"></x-input-error>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-800 mb-1">Description</label>
                    <textarea name="description" rows="4" class="block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 p-3" placeholder="Brief description about the task"></textarea>
                    <x-input-error name="description"></x-input-error>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">Due Date</label>
                    <input type="date" name="due_date" class="block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 p-3">
                    <x-input-error name="due_date"></x-input-error>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">Attachments</label>
                    <input type="file" name="attachments[]" multiple class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    <x-input-error name="attachments"></x-input-error>
                </div>
            </div>

            <!-- Staff Selection -->
            <div>
                <h2 class="text-xl font-bold text-slate-800 mb-4">Assign to Staff/lecturer</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Example Card -->
                    @foreach($data as $item)
                        <label class="relative cursor-pointer border rounded-xl p-5 bg-white hover:shadow-lg hover:border-sky-600 transition group">
                            <input type="radio" name="assigned_staff" value="{{$item['user']->id}}" class="absolute right-4 top-4 w-5 h-5 accent-sky-600">
                            <div class="flex items-center gap-4">
                                <img src="{{asset('logo/formal.jpg')}}" alt="Profile" class="w-14 h-14 rounded-full object-cover border border-gray-300">
                                <div>
                                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                        {{$item['user']->name}}
                                        <span class="text-xs bg-sky-100 text-sky-800 font-medium px-2 py-0.5 rounded-full">{{$item['user']->role}}</span>
                                    </h3>
                                    <p class="text-sm text-slate-500 italic">{{$item['user']->description}}</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-1 text-sm">
                                <p class="flex items-center gap-2"><span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span> High: <strong>{{$item['priority_count']['high']}}</strong></p>
                                <p class="flex items-center gap-2"><span class="inline-block w-3 h-3 bg-yellow-400 rounded-full"></span> Medium: <strong>{{$item['priority_count']['medium']}}</strong></p>
                                <p class="flex items-center gap-2"><span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span> Low: <strong>{{$item['priority_count']['low']}}</strong></p>
                            </div>
                            <x-input-error name="assigned_staff"></x-input-error>
                        </label>
                    @endforeach

                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <i class="bi bi-plus-circle text-lg"></i> Create Task
                </button>
            </div>
        </form>
    </div>

</x-layout-hod>
