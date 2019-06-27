<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachHouseBoardRequest;
use App\Http\Requests\UpdateAttachHouseBoardRequest;
use App\Repositories\AttachHouseBoardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttachHouseBoardController extends AppBaseController
{
    /** @var  AttachHouseBoardRepository */
    private $attachHouseBoardRepository;

    public function __construct(AttachHouseBoardRepository $attachHouseBoardRepo)
    {
        $this->attachHouseBoardRepository = $attachHouseBoardRepo;
    }

    /**
     * Display a listing of the AttachHouseBoard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attachHouseBoardRepository->pushCriteria(new RequestCriteria($request));
        $attachHouseBoards = $this->attachHouseBoardRepository->all();

        return view('attach_house_boards.index')
            ->with('attachHouseBoards', $attachHouseBoards);
    }

    /**
     * Show the form for creating a new AttachHouseBoard.
     *
     * @return Response
     */
    public function create()
    {
        return view('attach_house_boards.create');
    }

    /**
     * Store a newly created AttachHouseBoard in storage.
     *
     * @param CreateAttachHouseBoardRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachHouseBoardRequest $request)
    {
        $input = $request->all();

        $attachHouseBoard = $this->attachHouseBoardRepository->create($input);

        Flash::success('Attach House Board saved successfully.');

        return redirect(route('attachHouseBoards.index'));
    }

    /**
     * Display the specified AttachHouseBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachHouseBoard = $this->attachHouseBoardRepository->findWithoutFail($id);

        if (empty($attachHouseBoard)) {
            Flash::error('Attach House Board not found');

            return redirect(route('attachHouseBoards.index'));
        }

        return view('attach_house_boards.show')->with('attachHouseBoard', $attachHouseBoard);
    }

    /**
     * Show the form for editing the specified AttachHouseBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachHouseBoard = $this->attachHouseBoardRepository->findWithoutFail($id);

        if (empty($attachHouseBoard)) {
            Flash::error('Attach House Board not found');

            return redirect(route('attachHouseBoards.index'));
        }

        return view('attach_house_boards.edit')->with('attachHouseBoard', $attachHouseBoard);
    }

    /**
     * Update the specified AttachHouseBoard in storage.
     *
     * @param  int              $id
     * @param UpdateAttachHouseBoardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachHouseBoardRequest $request)
    {
        $attachHouseBoard = $this->attachHouseBoardRepository->findWithoutFail($id);

        if (empty($attachHouseBoard)) {
            Flash::error('Attach House Board not found');

            return redirect(route('attachHouseBoards.index'));
        }

        $attachHouseBoard = $this->attachHouseBoardRepository->update($request->all(), $id);

        Flash::success('Attach House Board updated successfully.');

        return redirect(route('attachHouseBoards.index'));
    }

    /**
     * Remove the specified AttachHouseBoard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachHouseBoard = $this->attachHouseBoardRepository->findWithoutFail($id);

        if (empty($attachHouseBoard)) {
            Flash::error('Attach House Board not found');

            return redirect(route('attachHouseBoards.index'));
        }

        $this->attachHouseBoardRepository->delete($id);

        Flash::success('Attach House Board deleted successfully.');

        return redirect(route('attachHouseBoards.index'));
    }
}
