<?php
/**
 * Created by PhpStorm.
 * User: abhijitgupta
 * Date: 17/11/18
 * Time: 12:07 PM
 */

namespace App;



use Illuminate\Database\Eloquent\Model;

class GroupList extends Model
{

    protected $table = 'group_list';
    public $timestamps = false;

    public function todo()
    {
        return $this->hasMany('App\TodoList');
    }
}