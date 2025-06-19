<x-layout>
    <x-slot:heading>USER LIST</x-slot:heading>

    <div class="mt-8" x-data="modalHandler"> <!-- Attach Alpine data here -->
        <!-- Search Bar -->
        <form method="GET" action="{{ route('user.list') }}" class="flex items-center mb-8 gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Enter user name"
                class="border border-slate-300 rounded-md px-4 py-2 w-64 shadow-sm"
            />
            <button
                type="submit"
                class="bg-blue-700 hover:bg-blue-900 text-white font-bold px-5 py-2 rounded-md flex items-center gap-2 shadow-lg border border-blue-900"
            >
                <i class="bi bi-search"></i>
                Search
            </button>
        </form>
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif
        <!-- User Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase">NAME</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase">EMAIL</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase">PHONE</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase">ROLE</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase">DEPARTMENT</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-slate-700 uppercase">ACTIONS</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->phone }}</td>
                        <td class="px-6 py-4 capitalize">{{ $user->role }}</td>
                        <td class="px-6 py-4">{{ $user->department->name ?? '-' }}</td>
                        <td class="px-6 py-4 flex gap-2 justify-center">
                            <!-- Update Password Modal Trigger -->
                            <button
                                @click="openModal = 'password-{{ $user->id }}'"
                                class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-3 py-1 rounded flex items-center gap-1 shadow-lg border border-yellow-600"
                                title="Update Password"
                            >
                                <i class="bi bi-key-fill"></i>
                                Update Password
                            </button>
                            <!-- Edit -->
                            <a href="{{ route('user.edit', $user->id) }}"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-3 py-1 rounded flex items-center gap-1 shadow-lg border border-blue-800"
                               title="Edit">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>
                            <!-- Delete Modal Trigger -->
                            <button
                                @click="openModal = 'delete-{{ $user->id }}'"
                                class="bg-red-600 hover:bg-red-800 text-white font-bold px-3 py-1 rounded flex items-center gap-1 shadow-lg border border-red-900"
                                title="Delete"
                            >
                                <i class="bi bi-trash-fill"></i>
                                Delete
                            </button>

                            <!-- Update Password Modal -->
                            <div
                                x-show="openModal === 'password-{{ $user->id }}'"
                                x-transition
                                class="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
                            >
                                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                                    <h3 class="text-lg font-semibold mb-4">Update Password</h3>
                                    <form method="POST" action="{{ route('user.updatePassword', $user->id) }}">
                                        @csrf
                                        <input type="password" name="password" placeholder="New Password" required class="w-full border border-slate-300 rounded-md px-4 py-2 mb-4" />
                                        <div class="flex justify-end gap-2">
                                            <button type="button" @click="openModal = null" class="px-4 py-2 rounded bg-slate-200 hover:bg-slate-300">Cancel</button>
                                            <button type="submit" class="px-4 py-2 rounded bg-yellow-600 text-white hover:bg-yellow-700">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div
                                x-show="openModal === 'delete-{{ $user->id }}'"
                                x-transition
                                class="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
                            >
                                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                                    <h3 class="text-lg font-semibold mb-4 text-red-700">Delete User</h3>
                                    <p class="mb-4">Are you sure you want to delete <span class="font-bold">{{ $user->name }}</span>?</p>
                                    <form method="POST" action="{{ route('user.delete', $user->id) }}">
                                        @csrf
                                        <div class="flex justify-end gap-2">
                                            <button type="button" @click="openModal = null" class="px-4 py-2 rounded bg-slate-200 hover:bg-slate-300">Cancel</button>
                                            <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-slate-500">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('modalHandler', () => ({
                openModal: null
            }));
        });
    </script>
</x-layout>
