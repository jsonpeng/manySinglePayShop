<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGolServicesRequest;
use App\Http\Requests\UpdateGolServicesRequest;
use App\Repositories\GolServicesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GolServicesController extends AppBaseController
{
    /** @var  GolServicesRepository */
    private $golServicesRepository;

    public function __construct(GolServicesRepository $golServicesRepo)
    {
        $this->golServicesRepository = $golServicesRepo;
    }

    /**
     * Display a listing of the GolServices.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->golServicesRepository->pushCriteria(new RequestCriteria($request));
        $golServices = $this->golServicesRepository->paginate(15);

        return view('gol_services.index')
            ->with('golServices', $golServices);
    }

    /**
     * Show the form for creating a new GolServices.
     *
     * @return Response
     */
    public function create()
    {
        return view('gol_services.create');
    }

    /**
     * Store a newly created GolServices in storage.
     *
     * @param CreateGolServicesRequest $request
     *
     * @return Response
     */
    public function store(CreateGolServicesRequest $request)
    {
        $input = $request->all();

        $golServices = $this->golServicesRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('golServices.index'));
    }

    /**
     * Display the specified GolServices.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $golServices = $this->golServicesRepository->findWithoutFail($id);

        if (empty($golServices)) {
            Flash::error('Gol Services not found');

            return redirect(route('golServices.index'));
        }

        return view('gol_services.show')->with('golServices', $golServices);
    }

    /**
     * Show the form for editing the specified GolServices.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $golServices = $this->golServicesRepository->findWithoutFail($id);

        if (empty($golServices)) {
            Flash::error('Gol Services not found');

            return redirect(route('golServices.index'));
        }

        return view('gol_services.edit')->with('golServices', $golServices);
    }

    /**
     * Update the specified GolServices in storage.
     *
     * @param  int              $id
     * @param UpdateGolServicesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGolServicesRequest $request)
    {
        $golServices = $this->golServicesRepository->findWithoutFail($id);

        if (empty($golServices)) {
            Flash::error('Gol Services not found');

            return redirect(route('golServices.index'));
        }

        $golServices = $this->golServicesRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('golServices.index'));
    }

    /**
     * Remove the specified GolServices from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $golServices = $this->golServicesRepository->findWithoutFail($id);

        if (empty($golServices)) {
            Flash::error('Gol Services not found');

            return redirect(route('golServices.index'));
        }

        $this->golServicesRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('golServices.index'));
    }
}
