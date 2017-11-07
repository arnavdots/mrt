<?php namespace Modules\Task\Entities;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskMail;
use App\Helpers\MrtHelpers;
use App\Helpers\ImageHelpers;

class Task extends Model
{

    use Sortable;

    protected $fillable = ['sender_id', 'receiver_id', 'priority', 'is_public', 'is_completed'];
    public $sortable = ['is_public', 'created_at', 'priority'];

    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */

    public function users()
    {
        return $this->belongsTo('Modules\User\Entities\User', 'sender_id');
    }

    public function receivers()
    {
        return $this->belongsTo('Modules\User\Entities\User', 'receiver_id');
    }

    public function notes()
    {
        return $this->hasMany('Modules\Task\Entities\TaskNote')->orderBy('created_at', 'DESC');
    }

    public function taskMail($task)
    {
        // send email
        $to = 'testing123@yopmail.com';
        $data = array(
            'name' => MrtHelpers::concnate(@$task->receivers->first_name, @$task->receivers->last_name)
        );
        Mail::to($to)->send(new TaskMail($data));
    }

    public function notemedia($file, $task_id,$note_id)
    {
        $path = config('filesystems.disks.task_uploads.root');
        $imageObj = new ImageHelpers($file);
        if ($imageObj->uploaded) {
            $imageObj->file_new_name_body = "Note-".$note_id;
            
            $imageObj->Process($path.$task_id);
            if ($imageObj->processed) {
                $filedata['filename'] = $imageObj->file_dst_name;
                $filedata['filetype'] =  $imageObj->file_src_mime;
                return $filedata;
            } else {
                $errMsg[] = $imageObj->error;
                return $errMsg;
            }
        }
    }
}
