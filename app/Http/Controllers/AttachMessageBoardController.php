<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachMessageBoardRequest;
use App\Http\Requests\UpdateAttachMessageBoardRequest;
use App\Repositories\AttachMessageBoardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttachMessageBoardController extends AppBaseController
{
    /** @var  AttachMessageBoardRepository */
    private $attachMessageBoardRepository;

    public function __construct(AttachMessageBoardRepository $attachMessageBoardRepo)
    {
        $this->attachMessageBoardRepository = $attachMessageBoardRepo;
    }

    /**
     * Display a listing of the AttachMessageBoard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attachMessageBoardRepository->pushCriteria(new RequestCriteria($request));
        $attachMessageBoards = $this->attachMessageBoardRepository->all();

        return view('attach_message_boards.index')
            ->with('attachMessageBoards', $attachMessageBoards);
    }

    /**
     * Show the form for creating a new AttachMessageBoard.
     *
     * @return Response
     */
    public function create()
    {
        return view('attach_message_boards.create');
    }

    /**
     * Store a newly created AttachMessageBoard in storage.
     *
     * @param CreateAttachMessageBoardRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachMessageBoardRequest $request)
    {
        $input = $request->all();

        $attachMessageBoard = $this->attachMessageBoardRepository->create($input);

        Flash::success('Attach Message Board saved successfully.');

        return redirect(route('attachMessageBoards.index'));
    }

    /**
     * Display the specified AttachMessageBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachMessageBoard = $this->attachMessageBoardRepository->findWithoutFail($id);

        if (empty($attachMessageBoard)) {
            Flash::error('Attach Message Board not found');

            return redirect(route('attachMessageBoards.index'));
        }

        return view('attach_message_boards.show')->with('attachMessageBoard', $attachMessageBoard);
    }

    /**
     * Show the form for editing the specified AttachMessageBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachMessageBoard = $this->attachMessageBoardRepository->findWithoutFail($id);

        if (empty($attachMessageBoard)) {
            Flash::error('Attach Message Board not found');

            return redirect(route('attachMessageBoards.index'));
        }

        return view('attach_message_boards.edit')->with('attachMessageBoard', $attachMessageBoard);
    }

    /**
     * Update the specified AttachMessageBoard in storage.
     *
     * @param  int              $id
     * @param UpdateAttachMessageBoardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachMessageBoardRequest $request)
    {
        $attachMessageBoard = $this->attachMessageBoardRepository->findWithoutFail($id);

        if (empty($attachMessageBoard)) {
            Flash::error('Attach Message Board not found');

            return redirect(route('attachMessageBoards.index'));
        }

        $attachMessageBoard = $this->attachMessageBoardRepository->update($request->all(), $id);

        Flash::success('Attach Message Board updated successfully.');

        return redirect(route('attachMessageBoards.index'));
    }

    /**
     * Remove the specified AttachMessageBoard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachMessageBoard = $this->attachMessageBoardRepository->findWithoutFail($id);

        if (empty($attachMessageBoard)) {
            Flash::error('Attach Message Board not found');

            return redirect(route('attachMessageBoards.index'));
        }

        $this->attachMessageBoardRepository->delete($id);

        Flash::success('Attach Message Board deleted successfully.');

        return redirect(route('attachMessageBoards.index'));
    }
}
