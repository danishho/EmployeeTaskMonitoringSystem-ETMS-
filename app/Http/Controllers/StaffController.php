<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Task;
use App\Models\Task_progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $totalTask = \App\Models\Task::where('assigned_to', $userId)->count();
        $completedTask = \App\Models\Task::where('assigned_to', $userId)->where('status', 'Completed')->count();
        $inProgressTask = \App\Models\Task::where('assigned_to', $userId)->where('status', 'In Progress')->count();
        $notStartedTask = \App\Models\Task::where('assigned_to', $userId)->where('status', 'Not Started')->count();
        return view('staff.index', [
            'totalTask' => $totalTask,
            'completedTask' => $completedTask,
            'inProgressTask' => $inProgressTask,
            'notStartedTask' => $notStartedTask,
        ]);
    }

    public function task(Request $request){
        $user = Auth::user()->id;

        // Get filters from request
        $search = $request->input('search');
        $priority = $request->input('priority');
        $sort = $request->input('sort');

        // Build query
        $tasksQuery = Task::with(['assignedTo', 'task_progresses'])
            ->where('assigned_to', $user);

        if ($search) {
            $tasksQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        if ($priority && in_array(strtolower($priority), ['high','medium','low'])) {
            $tasksQuery->where('priority', strtolower($priority));
        }
        if ($sort === 'closest') {
            $tasksQuery->orderBy('dueDate', 'asc');
        } elseif ($sort === 'farthest') {
            $tasksQuery->orderBy('dueDate', 'desc');
        } else {
            $tasksQuery->orderBy('created_at', 'desc');
        }

        $tasks = $tasksQuery->get();


        // Prepare data for each task
        $tasksData = $tasks->map(function($task) {
            // Progress: get latest progressLevel or 0
            $latestProgress = $task->task_progresses->sortByDesc('created_at')->first();
            $progressLevel = $latestProgress ? $latestProgress->progressLevel : 0;
            $latestProgressTitle = $latestProgress ? $latestProgress->title : null;
            $latestProgressDescription = $latestProgress ? $latestProgress->description : null;
            $latestProgressDate = $latestProgress ? $latestProgress->created_at : null;

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'dueDate' => $task->dueDate,
                'priority' => $task->priority,
                'status' => $task->status,
                'progressLevel' => $progressLevel,
                'latestProgressTitle' => $latestProgressTitle,
                'latestProgressDescription' => $latestProgressDescription,
                'latestProgressDate' => $latestProgressDate,
                'message' => $task->message,
            ];
        });

        return view('staff.task', [
            'tasks' => $tasksData,
            'search' => $search,
            'priority' => $priority,
            'sort' => $sort,
        ]);
    }

    public function updateProgress(task $task){
        $task_id = $task->id;
        $progress = Task_progress::where('task_id', $task_id)
            ->orderByDesc('progressLevel')
            ->first();
        $highest = $progress->progressLevel ?? 0;
        return view('staff.update-progress',['task' => $task_id
        , 'existingProgress' => $highest]);
    }

    public function updateProgressStore(Request $request, task $task){

        $attributeValidate = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'progress' => 'required',
        ]);


        if ($attributeValidate['progress'] == 100) {
            $task->status = 'Completed';
            $task->save();
        }else{
            $task->status = "In Progress";
            $task->save();
        }

        $progress = Task_progress::create([
            'task_id' => $task->id,
            'title' => $attributeValidate['title'],
            'description' => $attributeValidate['description'],
            'progressLevel' => $attributeValidate['progress'],
        ]);

        if($request->hasFile('attachments')){
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');

                Attachment::create([
                    'task_progress_id' => $progress->id,
                    'filePath' => $path,
                    'fileName' => $file->getClientOriginalName(),
                    'fileType' => $file->getClientOriginalExtension(),
                    'fileDate' => now(),
                ]);
            }
        }

        return redirect()->route('staff.TaskDetail', $task->id)->with('success', 'Task progress record successfully.');

    }

    public function TaskDetail(Task $task){
        // Authorization: Ensure HOD can only view tasks from their department
//            if ($task->department_id !== Auth::user()->department_id) {
//                abort(403, 'You are not authorized to view this task.');
//            }

        // Eager load all necessary relationships to avoid N+1 queries
        $task->load([
            'assignedTo',
            'attachments' => function($query) { // Task-level attachments only
                $query->whereNull('task_progress_id');
            },
            'task_progresses' => function ($query) {
                // For each progress, also load its attachments and sort by latest first
                $query->with('attachments')->orderBy('created_at', 'desc');
            }
        ]);

        // Calculate overall progress from the latest update
        $latestProgress = $task->task_progresses->first();
        $overallProgress = $latestProgress ? $latestProgress->progressLevel : 0;

        return view('staff.task-detail', [
            'task' => $task,
            'overallProgress' => $overallProgress,
        ]);
    }

    public function TaskMarkComplete(Task $task){
        // Set task status to Completed
        $task->status = 'Completed';
        $task->save();

        // Update the most recent progress to 100 if exists
        $latestProgress = $task->task_progresses()->orderByDesc('created_at')->first();
        if ($latestProgress) {
            $latestProgress->progressLevel = 100;
            $latestProgress->save();
        }

        return redirect()->route('staff.TaskDetail', $task->id)->with('success', 'Task marked as completed!');
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user = Auth::user();
        $file = $request->file('profile_image');
        $path = $file->store('profile_images', 'public');
        $user->path = $path;
        $user->save();
        return redirect()->back()->with('success', 'Profile image updated!');
    }

}
