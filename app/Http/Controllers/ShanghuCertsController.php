<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShanghuCertsRequest;
use App\Http\Requests\UpdateShanghuCertsRequest;
use App\Repositories\ShanghuCertsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ShanghuCertsController extends AppBaseController
{
    /** @var  ShanghuCertsRepository */
    private $shanghuCertsRepository;

    public function __construct(ShanghuCertsRepository $shanghuCertsRepo)
    {
        $this->shanghuCertsRepository = $shanghuCertsRepo;
    }

    /**
     * Display a listing of the ShanghuCerts.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shanghuCertsRepository->pushCriteria(new RequestCriteria($request));
        $shanghuCerts = $this->shanghuCertsRepository->all();

        return view('shanghu_certs.index')
            ->with('shanghuCerts', $shanghuCerts);
    }

    /**
     * Show the form for creating a new ShanghuCerts.
     *
     * @return Response
     */
    public function create()
    {
        return view('shanghu_certs.create');
    }

    /**
     * Store a newly created ShanghuCerts in storage.
     *
     * @param CreateShanghuCertsRequest $request
     *
     * @return Response
     */
    public function store(CreateShanghuCertsRequest $request)
    {
        $input = $request->all();

        $shanghuCerts = $this->shanghuCertsRepository->create($input);

        Flash::success('Shanghu Certs saved successfully.');

        return redirect(route('shanghuCerts.index'));
    }

    /**
     * Display the specified ShanghuCerts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shanghuCerts = $this->shanghuCertsRepository->findWithoutFail($id);

        if (empty($shanghuCerts)) {
            Flash::error('Shanghu Certs not found');

            return redirect(route('shanghuCerts.index'));
        }

        return view('shanghu_certs.show')->with('shanghuCerts', $shanghuCerts);
    }

    /**
     * Show the form for editing the specified ShanghuCerts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shanghuCerts = $this->shanghuCertsRepository->findWithoutFail($id);

        if (empty($shanghuCerts)) {
            Flash::error('Shanghu Certs not found');

            return redirect(route('shanghuCerts.index'));
        }

        return view('shanghu_certs.edit')->with('shanghuCerts', $shanghuCerts);
    }

    /**
     * Update the specified ShanghuCerts in storage.
     *
     * @param  int              $id
     * @param UpdateShanghuCertsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShanghuCertsRequest $request)
    {
        $shanghuCerts = $this->shanghuCertsRepository->findWithoutFail($id);

        if (empty($shanghuCerts)) {
            Flash::error('Shanghu Certs not found');

            return redirect(route('shanghuCerts.index'));
        }

        $shanghuCerts = $this->shanghuCertsRepository->update($request->all(), $id);

        Flash::success('Shanghu Certs updated successfully.');

        return redirect(route('shanghuCerts.index'));
    }

    /**
     * Remove the specified ShanghuCerts from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shanghuCerts = $this->shanghuCertsRepository->findWithoutFail($id);

        if (empty($shanghuCerts)) {
            Flash::error('Shanghu Certs not found');

            return redirect(route('shanghuCerts.index'));
        }

        $this->shanghuCertsRepository->delete($id);

        Flash::success('Shanghu Certs deleted successfully.');

        return redirect(route('shanghuCerts.index'));
    }
}
