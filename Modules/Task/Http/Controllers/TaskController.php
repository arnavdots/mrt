<?php namespace Modules\Task\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Task\Http\Requests\TaskRequest;
use Modules\Task\Http\Requests\TaskNoteRequest;
use Modules\Task\Http\Requests\TaskEditRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\MrtHelpers;
use Auth;
use Modules\Task\Entities\Task;
use Modules\Task\Entities\TaskNote;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        try {
                        
            $url = route('task.create');
            $views = MrtHelpers::getTaskViews();
            $priorities = MrtHelpers::getTaskPriorities();
            $status = MrtHelpers::getTaskStatus();
            $consultants = MrtHelpers::getAllConsultants();
            // $results = Task::with('users')->get();
            $current_userid = Auth::guard('admin')->user()->id;

            $query = Task::query();  
            // ajax search
            if ($request->ajax()) {
                if (!empty($request->consultant)) {
                    $query->where('receiver_id', '=', $request->consultant);
                }
                if (!empty($request->priority)) {
                    $query->where('priority', '=', $request->priority);
                }
                if (!empty($request->is_completed)) {
                    $query->where('is_completed', '=', $request->is_completed);
                }
                if (isset($request->view) && $request->view != '') {
                    $query->where('is_public', '=', $request->view);
                }
                if (!empty($request->date_range)) {
                    $dateRange = explode("-", $request->date_range);
                    $query->whereDate('created_at', '>=', date('Y-m-d', strtotime(trim($dateRange[0]))));
                    $query->whereDate('created_at', '<=', date('Y-m-d', strtotime(trim($dateRange[1]))));
                }

                if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
                    $sort = $request->sort;
                    $order = $request->order;
                    $query->orderBy($sort, $order);
                }

                $query->where('receiver_id', '=', $current_userid)
                    ->orWhere('is_public', '=', 1);

                $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
                if ($request->action == 'search') {
                    return view('task::partials.listing', compact('results', 'current_userid', 'views', 'consultants', 'priorities', 'status', 'url'));
                } else {
                    return view('task::index', compact('results', 'current_userid', 'views', 'consultants', 'priorities', 'status', 'url'));
                }
            }
            // default last week records

            $query->where('receiver_id', '=', $current_userid)
                ->orWhere('is_public', '=', 1);

            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 day')));
            $query->whereDate('created_at', '<=', date('Y-m-d'));
            $query->orderBy('created_at', 'DESC');
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
        } catch (Exception $e) {
            return redirect('tasks')->with('error', $e->getMessage());
        }

        return view('task::index', compact('results', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $current_userid = Auth::guard('admin')->user()->id;
        $consultants = MrtHelpers::getAllConsultants();
        $views = MrtHelpers::getTaskViews();
        $priorities = MrtHelpers::getTaskPriorities();
        $status = MrtHelpers::getTaskStatus();
        $url = 'task.store';
        $task = new Task;
        return view('task::create', compact('task', 'url', 'current_userid', 'consultants', 'views', 'priorities', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(TaskRequest $request)
    {
        // dd($request->file('media_name'));
        //dd($request);
        try {

            $task = new Task;
            $task->sender_id = $request->sender_id;
            $task->receiver_id = $request->receiver_id;
            $task->priority = $request->priority;
            $task->is_public = $request->is_public;
            $task->is_completed = $request->is_completed;


            if ($task->save()) {

                $task->taskMail($task);

                $note = $task->notes()->create(['description' => $request->description, 'user_id' => $request->user_id]);

                $file = $_FILES['media_name'];

                if ($file['name']) {
                    $filedata = $task->notemedia($file, $task->id, $note->id);
                    $note->taskMedia()->create(['media_name' => $filedata['filename'], 'media_type' => $filedata['filetype']]);
                }

                return array(
                    'status' => 'success',
                    'message' => __('task::task.message.task_added'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('task::task.message.task_not_added'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('task::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {

        $current_userid = Auth::guard('admin')->user()->id;
        $consultants = MrtHelpers::getAllConsultants();
        $views = MrtHelpers::getTaskViews();
        $priorities = MrtHelpers::getTaskPriorities();
        $status = MrtHelpers::getTaskStatus();

        $url = 'task.update';
        $task_complete_url = 'taskCompleted';
        $note_url = 'taskNote.add';
        $task = Task::findOrFail($id);
        return view('task::edit', compact('task', 'url', 'note_url', 'task_complete_url', 'current_userid', 'consultants', 'views', 'priorities', 'status'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(TaskEditRequest $request)
    {

        try {

            $input = $request->except('_token');
            $task = Task::whereId($request->id)->update($input);
            if ($task) {



                return array(
                    'status' => 'success',
                    'message' => __('task::task.message.task_updated'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('task::task.message.task_not_updated'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    public function taskCompleted(Request $request)
    {
        try {
            $input = $request->except('_token');
            $task = Task::whereId($request->id)->update($input);
            if ($task) {
                return array(
                    'status' => 'success',
                    'message' => __('task::task.message.task_updated'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('task::task.message.task_not_updated'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function addNote(TaskNoteRequest $request)
    {
        try {
            $task = new Task;
            $file = $_FILES['media_name'];
            $note = TaskNote::create($request->all());

            if ($file['name']) {
                $filedata = $task->notemedia($file, $request->task_id, $note->id);
                $note->taskMedia()->create(['media_name' => $filedata['filename'], 'media_type' => $filedata['filetype']]);
            }

            if ($note) {
                return array(
                    'status' => 'success',
                    'message' => __('task::task.message.note_added'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('task::task.message.note_not_added'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }
}
