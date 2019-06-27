<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttentionHouseRequest;
use App\Http\Requests\UpdateAttentionHouseRequest;
use App\Repositories\AttentionHouseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttentionHouseController extends AppBaseController
{
    /** @var  AttentionHouseRepository */
    private $attentionHouseRepository;

    public function __construct(AttentionHouseRepository $attentionHouseRepo)
    {
        $this->attentionHouseRepository = $attentionHouseRepo;
    }

    /**
     * Display a listing of the AttentionHouse.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attentionHouseRepository->pushCriteria(new RequestCriteria($request));
        $attentionHouses = $this->attentionHouseRepository->all();

        return view('attention_houses.index')
            ->with('attentionHouses', $attentionHouses);
    }

    /**
     * Show the form for creating a new AttentionHouse.
     *
     * @return Response
     */
    public function create()
    {
        return view('attention_houses.create');
    }

    /**
     * Store a newly created AttentionHouse in storage.
     *
     * @param CreateAttentionHouseRequest $request
     *
     * @return Response
     */
    public function store(CreateAttentionHouseRequest $request)
    {
        $input = $request->all();

        $attentionHouse = $this->attentionHouseRepository->create($input);

        Flash::success('Attention House saved successfully.');

        return redirect(route('attentionHouses.index'));
    }

    /**
     * Display the specified AttentionHouse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attentionHouse = $this->attentionHouseRepository->findWithoutFail($id);

        if (empty($attentionHouse)) {
            Flash::error('Attention House not found');

            return redirect(route('attentionHouses.index'));
        }

        return view('attention_houses.show')->with('attentionHouse', $attentionHouse);
    }

    /**
     * Show the form for editing the specified AttentionHouse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attentionHouse = $this->attentionHouseRepository->findWithoutFail($id);

        if (empty($attentionHouse)) {
            Flash::error('Attention House not found');

            return redirect(route('attentionHouses.index'));
        }

        return view('attention_houses.edit')->with('attentionHouse', $attentionHouse);
    }

    /**
     * Update the specified AttentionHouse in storage.
     *
     * @param  int              $id
     * @param UpdateAttentionHouseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttentionHouseRequest $request)
    {
        $attentionHouse = $this->attentionHouseRepository->findWithoutFail($id);

        if (empty($attentionHouse)) {
            Flash::error('Attention House not found');

            return redirect(route('attentionHouses.index'));
        }

        $attentionHouse = $this->attentionHouseRepository->update($request->all(), $id);

        Flash::success('Attention House updated successfully.');

        return redirect(route('attentionHouses.index'));
    }

    /**
     * Remove the specified AttentionHouse from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attentionHouse = $this->attentionHouseRepository->findWithoutFail($id);

        if (empty($attentionHouse)) {
            Flash::error('Attention House not found');

            return redirect(route('attentionHouses.index'));
        }

        $this->attentionHouseRepository->delete($id);

        Flash::success('Attention House deleted successfully.');

        return redirect(route('attentionHouses.index'));
    }
}
