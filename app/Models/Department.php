<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
//    takkan seseab incemementing bodoh nie
    public $incrementing = false; // Because 'id' is a string
    protected $keyType = 'string';

    protected $fillable = ['id', 'name'];

    public function users()
    {
        return $this->hasMany(User::class, 'department', 'id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'department', 'id');
    }
}
