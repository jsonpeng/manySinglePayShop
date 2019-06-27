<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageBoardRequest;
use App\Http\Requests\UpdateMessageBoardRequest;
use App\Repositories\MessageBoardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MessageBoardController extends AppBaseController
{
    /** @var  MessageBoardRepository */
    private $messageBoardRepository;

    public function __construct(MessageBoardRepository $messageBoardRepo)
    {
        $this->messageBoardRepository = $messageBoardRepo;
    }

    /**
     * Display a listing of the MessageBoard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messageBoardRepository->pushCriteria(new RequestCriteria($request));
        $messageBoards = $this->messageBoardRepository->orderBy('created_at', 'desc')->paginate(15);

        return view('message_boards.index')
            ->with('messageBoards', $messageBoards);
    }

    /**
     * Show the form for creating a new MessageBoard.
     *
     * @return Response
     */
    public function create()
    {
        return view('message_boards.create');
    }

    /**
     * Store a newly created MessageBoard in storage.
     *
     * @param CreateMessageBoardRequest $request
     *
     * @return Response
     */
    public function store(CreateMessageBoardRequest $request)
    {
        $input = $request->all();

        $messageBoard = $this->messageBoardRepository->create($input);

        Flash::success('Message Board saved successfully.');

        return redirect(route('messageBoards.index'));
    }

    /**
     * Display the specified MessageBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $messageBoard = $this->messageBoardRepository->findWithoutFail($id);

        if (empty($messageBoard)) {
            Flash::error('Message Board not found');

            return redirect(route('messageBoards.index'));
        }

        return view('message_boards.show')->with('messageBoard', $messageBoard);
    }

    /**
     * Show the form for editing the specified MessageBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $messageBoard = $this->messageBoardRepository->findWithoutFail($id);

        if (empty($messageBoard)) {
            Flash::error('Message Board not found');

            return redirect(route('messageBoards.index'));
        }

        return view('message_boards.edit')->with('messageBoard', $messageBoard);
    }

    /**
     * Update the specified MessageBoard in storage.
     *
     * @param  int              $id
     * @param UpdateMessageBoardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessageBoardRequest $request)
    {
        $messageBoard = $this->messageBoardRepository->findWithoutFail($id);

        if (empty($messageBoard)) {
            Flash::error('Message Board not found');

            return redirect(route('messageBoards.index'));
        }

        $messageBoard = $this->messageBoardRepository->update($request->all(), $id);

        Flash::success('Message Board updated successfully.');

        return redirect(route('messageBoards.index'));
    }

    /**
     * Remove the specified MessageBoard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $messageBoard = $this->messageBoardRepository->findWithoutFail($id);

        if (empty($messageBoard)) {
            Flash::error('Message Board not found');

            return redirect(route('messageBoards.index'));
        }

        $this->messageBoardRepository->delete($id);

        Flash::success('Message Board deleted successfully.');

        return redirect(route('messageBoards.index'));
    }
}
