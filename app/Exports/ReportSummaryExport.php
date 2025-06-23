<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportSummaryExport implements FromCollection, WithHeadings
{
    protected $departmentId;
    protected $year;
    protected $month;

    public function __construct($departmentId, $year, $month)
    {
        $this->departmentId = $departmentId;
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        $users = User::where('department_id', $this->departmentId)
            ->whereIn('role', ['staff', 'lecturer'])
            ->get();

        $rows = [];
        foreach ($users as $user) {
            $tasks = Task::where('assigned_to', $user->id)
                ->whereYear('dueDate', $this->year)
                ->whereMonth('dueDate', $this->month)
                ->get();
            $row = [
                $user->name,
                (int) $tasks->count(),
                (int) $tasks->where('priority', 'low')->count(),
                (int) $tasks->where('priority', 'medium')->count(),
                (int) $tasks->where('priority', 'high')->count(),
                (int) $tasks->where('status', 'Completed')->count(),
                (int) $tasks->where('status', 'In Progress')->count(),
                (int) $tasks->where('status', 'Not Started')->count(),
                (int) $tasks->where('dueDate', '<', now()->toDateString())
                    ->where('status', '!=', 'Completed')->count(),
            ];
            $rows[] = $row;
        }
        return new Collection($rows);
    }

    public function headings(): array
    {
        return [
            'User',
            'Total Tasks',
            'Low',
            'Medium',
            'High',
            'Completed',
            'In Progress',
            'Not Started',
            'Overdue',
        ];
    }
} 