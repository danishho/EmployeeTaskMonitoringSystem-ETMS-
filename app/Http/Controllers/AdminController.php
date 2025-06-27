<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalHod = User::where('role', 'hod')->count();
        $totalLecturer = User::where('role', 'lecturer')->count();
        $totalStaff = User::where('role', 'staff')->count();

        return view('admin.index', [
            'totalUsers' => $totalUsers,
            'totalAdmin' => $totalAdmin,
            'totalHod' => $totalHod,
            'totalLecturer' => $totalLecturer,
            'totalStaff' => $totalStaff,
        ]);
    }
} 