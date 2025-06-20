<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ETMS</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center min-h-screen font-sans">
<div class="bg-white rounded-3xl shadow-xl p-10 w-full max-w-xl">
    <!-- Logo and Title -->
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('logo/kpm.png') }}" alt="Company Logo" class="w-28 h-28 object-contain mb-3">
        <h1 class="text-2xl font-extrabold text-gray-800 text-center leading-tight">
            Employee Task Monitoring System (ETMS)<br>

        </h1>
    </div>

    <!-- Login Form -->
    <form action="{{route('login')}}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
            <x-input-error name="email"></x-input-error>
        </div>

        <div>
            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
            <x-input-error name="password"></x-input-error>
        </div>

{{--        <div class="flex items-center justify-between">--}}
{{--            <label class="flex items-center text-sm font-semibold text-gray-600">--}}
{{--                <input type="checkbox" class="h-4 w-4 text-blue-600 mr-2">--}}
{{--                Remember me--}}
{{--            </label>--}}
{{--        </div>--}}

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition-all shadow-md">
            Log In
        </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-xs text-gray-400 mt-6">&copy; 2025 Employee Task Monitoring System. All rights reserved.</p>
</div>
</body>

</html>
