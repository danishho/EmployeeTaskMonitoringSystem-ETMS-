<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HodController extends Controller
{
    public function index(){
        return view('hod.index');
    }

    public function staffInfo(request $request){
        $hod= Auth::user()->department_id;
        $search = $request->input('search');
        $query = User::with('department')
            ->Where('department_id',$hod)
            ->WhereIn('role',['staff','lecturer']);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $users = $query->get();
        return view('hod.staff-information', compact('users', 'search'));

    }

    public function staffInfoStore(User $user, Request $request){
        $descriptionValidated = $request->validate([
            'description' => ['required']
        ]);
        $user->update($descriptionValidated);
        return redirect()->route('hod.staffInfo')->with('success', 'Description updated successfully!');
    }

    public function createTask()
    {
        $hod = Auth::user()->department_id;
        $users = User::with('department')
            ->Where('department_id',$hod)
            ->WhereIn('role',['staff','lecturer'])
            ->get();

        $data = [];

        foreach($users as $user){
            $tasks= Task::where('assigned_to',$user->id)->get();
            $data[] = [
              'user' => $user,
              'priority_count' => [
                  'high' => $tasks->where('priority', 'high')->count(),
                  'medium' => $tasks->where('priority', 'medium')->count(),
                  'low' => $tasks->where('priority', 'low')->count(),

              ]
            ];
        }

        return view('hod.create-task',compact('data'));
    }

    public function storeTask(Request $request){
        $attributesValidate=$request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'priority' => ['required'],
            'due_date' => ['required'],
            'assigned_staff' => ['required'],
        ]);



        $task = Task::create([
            'title' => $attributesValidate['title'],
            'description' => $attributesValidate['description'],
            'priority' => strtolower($attributesValidate['priority']),
            'dueDate' => $attributesValidate['due_date'],
            'assigned_to' => $attributesValidate['assigned_staff'],
            'created_by' => Auth::id(),
            'department_id' => Auth::user()->department_id,
        ]);



        if($request->hasFile('attachments')){
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');

                Attachment::create([
                    'task_id' => $task->id,
                    'filePath' => $path,
                    'fileName' => $file->getClientOriginalName(),
                    'fileType' => $file->getClientOriginalExtension(),
                    'fileDate' => now(),
                ]);
            }


        }

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function monitorTask(Request $request)
    {
        $hodDepartmentId = Auth::user()->department_id;

        // Get filters from request
        $search = $request->input('search');
        $priority = $request->input('priority');
        $sort = $request->input('sort');

        // Build query
        $tasksQuery = Task::with(['assignedTo', 'task_progresses'])
            ->where('department_id', $hodDepartmentId);

        if ($search) {
            $tasksQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('assignedTo', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%")
                         ->orWhere('description', 'like', "%$search%")
                         ;
                  });
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
                'assignedTo' => $task->assignedTo,
                'progressLevel' => $progressLevel,
                'latestProgressTitle' => $latestProgressTitle,
                'latestProgressDescription' => $latestProgressDescription,
                'latestProgressDate' => $latestProgressDate,
                'message' => $task->message,
            ];
        });

        return view('hod.monitor-task', [
            'tasks' => $tasksData,
            'search' => $search,
            'priority' => $priority,
            'sort' => $sort,
        ]);
    }

    public function monitorTaskDetail(Task $task){
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

            return view('hod.monitor-task-detail', [
                'task' => $task,
                'overallProgress' => $overallProgress,
            ]);
    }

}
