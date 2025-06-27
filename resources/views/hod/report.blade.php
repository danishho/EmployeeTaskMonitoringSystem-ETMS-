<x-layout-hod>
    <x-slot:heading>Task Performance Report</x-slot:heading>

    <div class="p-6 space-y-6">
        <!-- Filter Section -->
        <form method="GET" action="{{ route('hod.report') }}" class="bg-white p-6 rounded-lg shadow flex flex-wrap items-center gap-4 sticky top-0 z-10">
            <input type="month" name="month_year" value="{{ request('month_year') }}" class="border rounded p-2" />
            <input type="text" name="user" value="{{ $searchUser }}" placeholder="Search by user" class="border rounded p-2 flex-1" />
            <button
                type="submit"
                class="bg-blue-700 hover:bg-blue-900 text-white font-bold px-5 py-2 rounded-md flex items-center gap-2 shadow-lg border border-blue-900"
            >
                <i class="bi bi-search"></i>
                Search
            </button>
            <a href="{{ route('hod.report.download', ['month_year' => $monthYear ?? request('month_year')]) }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded flex items-center gap-2">
                <i class="bi bi-download"></i> Download Report
            </a>
        </form>

        <!-- Toast Message (for future use, hidden for now) -->
        {{--
        <div id="toast-success" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">✔️ Report successfully downloaded</strong>
        </div>
        <div id="toast-failed" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">❌ No data found for selected month/year</strong>
        </div>
        --}}

        <!-- Table Section -->
        @if(!$isEmpty)
        <div class="overflow-auto rounded-lg shadow border bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 sticky top-0">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">User</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Total Tasks</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Low</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Medium</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">High</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-green-700">Completed</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-yellow-600">In Progress</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Not Started</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-red-600">Overdue</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($summary as $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $row['user'] }}</td>
                        <td class="text-center">{{ $row['total'] }}</td>
                        <td class="text-center">{{ $row['low'] }}</td>
                        <td class="text-center">{{ $row['medium'] }}</td>
                        <td class="text-center">{{ $row['high'] }}</td>
                        <td class="text-center text-green-600 font-semibold">{{ $row['completed'] }}</td>
                        <td class="text-center text-yellow-600">{{ $row['in_progress'] }}</td>
                        <td class="text-center">{{ $row['not_started'] }}</td>
                        <td class="text-center text-red-600 font-semibold">{{ $row['overdue'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center p-10 text-gray-500">
            <i class="bi bi-emoji-frown text-4xl mb-4"></i>
            <p class="text-lg">No tasks found for this selection.</p>
        </div>
        @endif


    </div>
</x-layout-hod>
