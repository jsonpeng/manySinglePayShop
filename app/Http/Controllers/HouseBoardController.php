<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHouseBoardRequest;
use App\Http\Requests\UpdateHouseBoardRequest;
use App\Repositories\HouseBoardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class HouseBoardController extends AppBaseController
{
    /** @var  HouseBoardRepository */
    private $houseBoardRepository;

    public function __construct(HouseBoardRepository $houseBoardRepo)
    {
        $this->houseBoardRepository = $houseBoardRepo;
    }

    /**
     * Display a listing of the HouseBoard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->houseBoardRepository->pushCriteria(new RequestCriteria($request));
        $houseBoards = $this->houseBoardRepository->all();

        return view('house_boards.index')
            ->with('houseBoards', $houseBoards);
    }

    /**
     * Show the form for creating a new HouseBoard.
     *
     * @return Response
     */
    public function create()
    {
        return view('house_boards.create');
    }

    /**
     * Store a newly created HouseBoard in storage.
     *
     * @param CreateHouseBoardRequest $request
     *
     * @return Response
     */
    public function store(CreateHouseBoardRequest $request)
    {
        $input = $request->all();

        $houseBoard = $this->houseBoardRepository->create($input);

        Flash::success('House Board saved successfully.');

        return redirect(route('houseBoards.index'));
    }

    /**
     * Display the specified HouseBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $houseBoard = $this->houseBoardRepository->findWithoutFail($id);

        if (empty($houseBoard)) {
            Flash::error('House Board not found');

            return redirect(route('houseBoards.index'));
        }

        return view('house_boards.show')->with('houseBoard', $houseBoard);
    }

    /**
     * Show the form for editing the specified HouseBoard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $houseBoard = $this->houseBoardRepository->findWithoutFail($id);

        if (empty($houseBoard)) {
            Flash::error('House Board not found');

            return redirect(route('houseBoards.index'));
        }

        return view('house_boards.edit')->with('houseBoard', $houseBoard);
    }

    /**
     * Update the specified HouseBoard in storage.
     *
     * @param  int              $id
     * @param UpdateHouseBoardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHouseBoardRequest $request)
    {
        $houseBoard = $this->houseBoardRepository->findWithoutFail($id);

        if (empty($houseBoard)) {
            Flash::error('House Board not found');

            return redirect(route('houseBoards.index'));
        }

        $houseBoard = $this->houseBoardRepository->update($request->all(), $id);

        Flash::success('House Board updated successfully.');

        return redirect(route('houseBoards.index'));
    }

    /**
     * Remove the specified HouseBoard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $houseBoard = $this->houseBoardRepository->findWithoutFail($id);

        if (empty($houseBoard)) {
            Flash::error('House Board not found');

            return redirect(route('houseBoards.index'));
        }

        $this->houseBoardRepository->delete($id);

        Flash::success('House Board deleted successfully.');

        return redirect(route('houseBoards.index'));
    }
}
