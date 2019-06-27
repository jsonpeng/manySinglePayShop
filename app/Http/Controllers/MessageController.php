<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Repositories\MessageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Message;
use Log;

class MessageController extends AppBaseController
{
    /** @var  MessageRepository */
    private $messageRepository;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepository = $messageRepo;
    }

    //批量导出
    public function reportMany(Request $request){
        if($this->messageRepository->model()::orderBy('created_at','desc')->count() == 0){
            Flash::error('当前没有数据可以导出');
            return redirect(route('messages.index'));
        }
        $time = Carbon::now()->format('Y-m-d H:i:s');
        $lists = $this->messageRepository->model()::orderBy('created_at','desc');
        Excel::create('截止到'.$time.'预约记录', function($excel) use($lists) {
            //第二列sheet
            $excel->sheet('预约记录列表', function ($sheet) use ($lists) {
            $sheet->setWidth(array(
                'A' => 20,
                'B' => 15,
                'C' => 15,
                'D' => 20
            ));
            $sheet->appendRow(array('姓名', '手机号', '预约课程名称', '提交预约时间'));
                $lists = $lists->chunk(100, function($lists) use(&$sheet) {
                   // Log::info($lists);
                    //$item = $item->items()->get();
                    $lists->each(function ($item, $key) use (&$sheet) {
                        $sheet->appendRow(array(
                            $item->name,
                            $item->tel,
                            $item->info,
                            $item->created_at
                        ));
                    });
                
            });
        });
        })->download('xls');
    }

    public function allDel(Request $request){
        Message::orderBy('created_at', 'desc')->delete();

        Flash::success('信息全部删除成功');

        return redirect(route('messages.index'));
    }

    /**
     * Display a listing of the Message.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->messageRepository->pushCriteria(new RequestCriteria($request));
        $messages = Message::orderBy('created_at', 'desc')->paginate(15);

        return view('messages.index')
            ->with('messages', $messages);
    }

    /**
     * Show the form for creating a new Message.
     *
     * @return Response
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created Message in storage.
     *
     * @param CreateMessageRequest $request
     *
     * @return Response
     */
    public function store(CreateMessageRequest $request)
    {
        $input = $request->all();

        $message = $this->messageRepository->create($input);

        Flash::success('消息添加成功.');

        return redirect(route('messages.index'));
    }

    /**
     * Display the specified Message.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            Flash::error('Message not found');

            return redirect(route('messages.index'));
        }

        return view('messages.show')->with('message', $message);
    }

    /**
     * Show the form for editing the specified Message.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            Flash::error('Message not found');

            return redirect(route('messages.index'));
        }

        return view('messages.edit')->with('message', $message);
    }

    /**
     * Update the specified Message in storage.
     *
     * @param  int              $id
     * @param UpdateMessageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessageRequest $request)
    {
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            Flash::error('Message not found');

            return redirect(route('messages.index'));
        }

        $message = $this->messageRepository->update($request->all(), $id);

        Flash::success('Message updated successfully.');

        return redirect(route('messages.index'));
    }

    /**
     * Remove the specified Message from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            Flash::error('信息不存在');

            return redirect(route('messages.index'));
        }

        $this->messageRepository->delete($id);

        Flash::success('信息删除成功');

        return redirect(route('messages.index'));
    }
}
