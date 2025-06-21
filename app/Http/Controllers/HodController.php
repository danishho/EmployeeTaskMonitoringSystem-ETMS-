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
}
