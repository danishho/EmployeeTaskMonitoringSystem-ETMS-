<x-layout>
    <x-slot:heading>Edit User</x-slot:heading>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-8xl">

        <form method="POST" action="{{ route('user.editStore', $user->id) }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block mb-2 font-medium text-slate-800">Name<span class="text-red-700">*</span></label>
                <input type="text" id="name" name="name" required class="w-full border border-slate-300 rounded-md px-4 py-2" value="{{ old('name', $user->name) }}"  />
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2 font-medium text-slate-800">Email<span class="text-red-700">*</span></label>
                <input type="email" id="email" name="email" required class="w-full border border-slate-300 rounded-md px-4 py-2" value="{{ old('email', $user->email) }}" />
                <x-input-error name="email"></x-input-error>
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-2 font-medium text-slate-800">Password <span class="text-gray-700 text-xs">(optional)</span></label>
                <input type="password" id="password" name="password" class="w-full border border-slate-300 rounded-md px-4 py-2" placeholder="Leave blank to keep current password" />
                <x-input-error name="password"></x-input-error>
            </div>
            <div class="mb-4">
                <label for="phone" class="block mb-2 font-medium text-slate-800">Phone<span class="text-red-700">*</span></label>
                <input type="tel" id="phone" name="phone" required class="w-full border border-slate-300 rounded-md px-4 py-2" value="{{ old('phone', $user->phone) }}" />
                <x-input-error name="phone"></x-input-error>
            </div>
            <div class="mb-4">
                <label for="role" class="block mb-2 font-medium text-slate-800">Role<span class="text-red-700">*</span></label>
                <select id="role" name="role" required class="w-full border border-slate-300 rounded-md px-4 py-2">
                    <option value="">-- Select Role --</option>
                    <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="lecturer" {{ old('role', $user->role) == 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                    <option value="hod" {{ old('role', $user->role) == 'hod' ? 'selected' : '' }}>HOD</option>
                </select>
                <x-input-error name="role"></x-input-error>
            </div>
            <div class="mb-6">
                <label for="department" class="block mb-2 font-medium text-slate-800">Department<span class="text-red-700">*</span></label>
                <select id="department" name="department_id" required class="w-full border border-slate-300 rounded-md px-4 py-2">
                    <option value="">-- Select Department --</option>
                    <option value="JSQ" {{ old('department_id', $user->department_id) == 'JSQ' ? 'selected' : '' }}>Jabatan Sains Quantitative</option>
                    <option value="JPA" {{ old('department_id', $user->department_id) == 'JPA' ? 'selected' : '' }}>Jabatan Pengajian Am</option>
                    <option value="JE" {{ old('department_id', $user->department_id) == 'JE' ? 'selected' : '' }}>Jabatan English</option>
                    <option value="JPP" {{ old('department_id', $user->department_id) == 'JPP' ? 'selected' : '' }}>Jabatan Pengurusan Perniagaan</option>
                </select>
                <x-input-error name="department"></x-input-error>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-2 rounded-md">Update</button>
            </div>
        </form>
    </div>

</x-layout>
