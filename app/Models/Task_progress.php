<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_progress extends Model
{
    protected $guarded=[];

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function attachments(){
        return $this->hasMany(Attachment::class);
    }
}
