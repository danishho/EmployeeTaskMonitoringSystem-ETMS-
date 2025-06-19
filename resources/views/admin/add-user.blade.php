<x-layout>
    <x-slot:heading>add user</x-slot:heading>
    @if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
        {{ session('success') }}
    </div>
    @endif
    <div class="flex gap-6 p-8">
        <!-- Form Section -->
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-8xl">
            <h2 class="text-xl font-semibold text-slate-800 mb-6">User Registration</h2>
            <form method="POST" action="/user/add">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2 font-medium text-slate-800">Name</label>
                    <input type="text" id="name" name="name" required class="w-full border border-slate-300 rounded-md px-4 py-2" />
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2 font-medium text-slate-800">Email</label>
                    <input type="email" id="email" name="email" required class="w-full border border-slate-300 rounded-md px-4 py-2" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-2 font-medium text-slate-800">Password</label>
                    <input type="password" id="password" name="password" required class="w-full border border-slate-300 rounded-md px-4 py-2" />
                </div>
                <div class="mb-4">
                    <label for="phone" class="block mb-2 font-medium text-slate-800">Phone</label>
                    <input type="tel" id="phone" name="phone" required class="w-full border border-slate-300 rounded-md px-4 py-2" />
                </div>
                <div class="mb-4">
                    <label for="role" class="block mb-2 font-medium text-slate-800">Role</label>
                    <select id="role" name="role" required class="w-full border border-slate-300 rounded-md px-4 py-2">
                        <option value="">-- Select Role --</option>
                        <option value="staff">Staff</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="hod">HOD</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="department" class="block mb-2 font-medium text-slate-800">Department</label>
                    <select id="department" name="department_id" required class="w-full border border-slate-300 rounded-md px-4 py-2">
                        <option value="">-- Select Department --</option>
                        <option value="JSQ">Jabatan Sains Quantitative</option>
                        <option value="JPA">Jabatan Pengajian Am</option>
                        <option value="JE">Jabatan English</option>
                        <option value="JPP">Jabatan Pengurusan Perniagaan</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-2 rounded-md">Register</button>
                </div>
            </form>
        </div>


        <!-- Upload Section -->
        <div class="bg-white p-8 rounded-lg shadow-md w-full mb-0">
            <h2 class="text-xl font-semibold text-slate-800 mb-6">Upload User List</h2>
            <form method="POST" enctype="multipart/form-data" action="/excel/add" \>
                @csrf
                <input type="file" name="excel" class="w-full border border-slate-300 rounded-md px-4 py-2 mb-4" accept=".xlsx," />
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md mb-3">Upload</button>
            </form>
            <a href="/export/user"><button type="button" class="w-full bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-md">Download Excel Format</button></a>
        </div>
    </div>
</x-layout>
