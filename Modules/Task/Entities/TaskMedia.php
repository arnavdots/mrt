<?php

namespace Modules\Task\Entities;

use Illuminate\Database\Eloquent\Model;

class TaskMedia extends Model
{
    protected $fillable = ['media_name','media_type','task_note_id'];
    
    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */
    
    public function taskNote()
    {
        return $this->belongsTo('Modules\TaskNote\Entities\TaskNote','task_note_id');
    }
    
}
