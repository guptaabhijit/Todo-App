<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{

    protected $table = 'todo_lists';
    public $timestamps = false;
}
