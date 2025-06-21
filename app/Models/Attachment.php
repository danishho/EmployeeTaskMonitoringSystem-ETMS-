<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [];

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function task_progress(){
        return $this->belongsTo(Task_progress::class);
    }
}
