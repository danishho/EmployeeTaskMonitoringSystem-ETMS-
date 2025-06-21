<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ETMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex bg-gray-100 font-sans ">
<aside class="w-72 bg-slate-900 text-white flex flex-col justify-between border-r border-slate-700 min-h-screen">
    <div>
        <div class="p-6 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="flex flex-col">
                    <span class="font-semibold">{{\Illuminate\Support\Facades\Auth::user()->name;}}</span>
                    <small class="text-slate-400">HOD - {{\Illuminate\Support\Facades\Auth::user()->department->name;}}</small>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="text-xs uppercase text-slate-400 mb-4">ETMS - Employee Task Monitoring</div>

            <a href="/" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-house-door"></i> <span>Dashboard</span>
            </a>
            <a href="{{Route('hod.staffInfo')}}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-person-badge"></i> <span>Staff Information</span>
            </a>
            <a href="/task" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-list-check"></i> <span>Manage Task</span>
            </a>
            <a href="{{Route('hod.createTask')}}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-pencil-square"></i> <span>Create Task</span>
            </a>
            <a href="/task/monitor" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-clipboard-check"></i> <span>Monitor Task</span>
            </a>
            <a href="/report" class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 rounded-md p-3 text-base">
                <i class="bi bi-bar-chart-line"></i> <span>Report</span>
            </a>
        </div>
    </div>
    <div class="p-6 border-t border-slate-700">
        <a href="{{route('logout')}}">
            <button class="w-full bg-red-800 hover:bg-red-600 text-slate-300 flex items-center gap-3 p-3 rounded-md text-base">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </a>
    </div>
</aside>

<main class="flex-1 flex flex-col">
    <div class="p-7 bg-slate-200 border-b border-slate-300">
        <h1 class="text-2xl font-semibold text-slate-800">{{$heading}}</h1>
    </div>
    {{$slot}}
</main>
</body>
</html>
