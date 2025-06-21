<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded =[];

    public function creator(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function assignedTo(){
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function task_progresses(){
        return $this->hasMany(Task_progress::class,'task_id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function attachments(){
        return $this->hasMany(Attachment::class,'task_id');
    }
}
