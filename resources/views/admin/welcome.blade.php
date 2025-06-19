<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add User + Upload Excel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="h-screen flex bg-gray-100 font-sans">
<aside class="w-72 bg-slate-900 text-white flex flex-col justify-between border-r border-slate-700">
    <div>
        <div class="p-6 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="flex flex-col">
                    <span class="font-semibold">Admin User</span>
                    <small class="text-slate-400">System Administrator</small>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="text-xs uppercase text-slate-400 mb-4">ETMS - Employee Task Monitoring</div>
            <a href="/" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-house-door"></i> <span>Dashboard</span>
            </a>
            <a href="/employees" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-list-ul"></i> <span>User List</span>
            </a>
            <a href="/user/add" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-plus-circle"></i> <span>Add User</span>
            </a>
        </div>
    </div>
    <div class="p-6 border-t border-slate-700">
        <button class="w-full bg-red-800 hover:bg-red-600 text-slate-300 flex items-center gap-3 p-3 rounded-md text-base">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>
</aside>

<main class="flex-1 flex flex-col">
    <div class="p-7 bg-slate-200 border-b border-slate-300">
        <h1 class="text-2xl font-semibold text-slate-800">Add User</h1>
    </div>
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
                    <label for="password_confirmation" class="block mb-2 font-medium text-slate-800">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border border-slate-300 rounded-md px-4 py-2" />
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
                    <select id="department" name="department" required class="w-full border border-slate-300 rounded-md px-4 py-2">
                        <option value="">-- Select Department --</option>
                        <option value="science">Science</option>
                        <option value="math">Math</option>
                        <option value="bio">Biology</option>
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
            <input type="file" class="w-full border border-slate-300 rounded-md px-4 py-2 mb-4" />
            <button type="button" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md mb-3">Upload</button>
            <button type="button" class="w-full bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-md">Download Excel Format</button>
        </div>
    </div>
</main>
</body>
</html>
