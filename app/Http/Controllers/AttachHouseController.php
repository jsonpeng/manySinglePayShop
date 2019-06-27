<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachHouseRequest;
use App\Http\Requests\UpdateAttachHouseRequest;
use App\Repositories\AttachHouseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttachHouseController extends AppBaseController
{
    /** @var  AttachHouseRepository */
    private $attachHouseRepository;

    public function __construct(AttachHouseRepository $attachHouseRepo)
    {
        $this->attachHouseRepository = $attachHouseRepo;
    }

    /**
     * Display a listing of the AttachHouse.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attachHouseRepository->pushCriteria(new RequestCriteria($request));
        $attachHouses = $this->attachHouseRepository->all();

        return view('attach_houses.index')
            ->with('attachHouses', $attachHouses);
    }

    /**
     * Show the form for creating a new AttachHouse.
     *
     * @return Response
     */
    public function create()
    {
        return view('attach_houses.create');
    }

    /**
     * Store a newly created AttachHouse in storage.
     *
     * @param CreateAttachHouseRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachHouseRequest $request)
    {
        $input = $request->all();

        $attachHouse = $this->attachHouseRepository->create($input);

        Flash::success('Attach House saved successfully.');

        return redirect(route('attachHouses.index'));
    }

    /**
     * Display the specified AttachHouse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachHouse = $this->attachHouseRepository->findWithoutFail($id);

        if (empty($attachHouse)) {
            Flash::error('Attach House not found');

            return redirect(route('attachHouses.index'));
        }

        return view('attach_houses.show')->with('attachHouse', $attachHouse);
    }

    /**
     * Show the form for editing the specified AttachHouse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachHouse = $this->attachHouseRepository->findWithoutFail($id);

        if (empty($attachHouse)) {
            Flash::error('Attach House not found');

            return redirect(route('attachHouses.index'));
        }

        return view('attach_houses.edit')->with('attachHouse', $attachHouse);
    }

    /**
     * Update the specified AttachHouse in storage.
     *
     * @param  int              $id
     * @param UpdateAttachHouseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachHouseRequest $request)
    {
        $attachHouse = $this->attachHouseRepository->findWithoutFail($id);

        if (empty($attachHouse)) {
            Flash::error('Attach House not found');

            return redirect(route('attachHouses.index'));
        }

        $attachHouse = $this->attachHouseRepository->update($request->all(), $id);

        Flash::success('Attach House updated successfully.');

        return redirect(route('attachHouses.index'));
    }

    /**
     * Remove the specified AttachHouse from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachHouse = $this->attachHouseRepository->findWithoutFail($id);

        if (empty($attachHouse)) {
            Flash::error('Attach House not found');

            return redirect(route('attachHouses.index'));
        }

        $this->attachHouseRepository->delete($id);

        Flash::success('Attach House deleted successfully.');

        return redirect(route('attachHouses.index'));
    }
}
