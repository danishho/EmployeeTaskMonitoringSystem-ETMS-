<x-layout-staff>
    <x-slot:heading>Update Progress</x-slot:heading>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-8xl">
        <form method="POST" action="{{ route('staff.updateProgressStore', $task) }}" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label for="title" class="block mb-2 font-medium text-slate-800">Title<span class="text-red-700">*</span></label>
                <input type="text" id="title" name="title" required
                       class="w-full border border-slate-300 rounded-md px-4 py-2" />
                <x-input-error name="title"></x-input-error>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block mb-2 font-medium text-slate-800">Description<span class="text-red-700">*</span></label>
                <textarea id="description" name="description" rows="4"
                          class="block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 p-3"
                          placeholder="Brief description about the task"></textarea>
                <x-input-error name="description"></x-input-error>
            </div>

            {{-- Attachment --}}
            <div class="mb-4">
                <label for="attachments" class="block mb-2 font-medium text-slate-800">Attachment(s)</label>
                <input type="file" id="attachments" name="attachments[]" multiple
                       class="w-full text-slate-700 border border-slate-300 rounded-md px-4 py-2" />
                <p class="text-sm text-gray-500 mt-1">You can select multiple files</p>
                <x-input-error name="attachments"></x-input-error>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium text-slate-800">Current Progress</label>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $existingProgress }}%"></div>
                </div>
                <p class="text-sm text-gray-700">Currently at {{ $existingProgress }}%</p>

            </div>


            {{-- Progress Percentage --}}
            <div class="mb-6">
                <label for="progress" class="block mb-2 font-medium text-slate-800">Progress (%)<span class="text-red-700">*</span></label>
                <input
                    type="number"
                    id="progress"
                    name="progress"
                    min="{{ $existingProgress + 1 }}"
                    max="100"
                    step="1"
                    required
                    placeholder="{{ $existingProgress + 1 }} - 100"
                    class="w-full border border-slate-300 rounded-md px-4 py-2"
                />
                <x-input-error name="progress"></x-input-error>
                <p class="text-sm text-gray-500 mt-1">
                    Must be an integer greater than current progress ({{ $existingProgress }}%)
                </p>

            </div>

            {{-- Submit --}}
            <div class="text-right">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-2 rounded-md">Submit</button>
            </div>
        </form>
    </div>
</x-layout-staff>
