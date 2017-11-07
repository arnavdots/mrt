<?php namespace Modules\Task\Entities;

use Illuminate\Database\Eloquent\Model;

class TaskNote extends Model
{

    protected $fillable = ['description', 'task_id', 'user_id'];

    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */

    public function task()
    {
        return $this->belongsTo('Modules\Task\Entities\Task');
    }

    public function users()
    {
        return $this->belongsTo('Modules\User\Entities\User', 'user_id');
    }
    
    public function taskMedia()
    {
        return $this->hasMany('Modules\Task\Entities\TaskMedia')->orderBy('created_at', 'DESC');
    }
    
}
