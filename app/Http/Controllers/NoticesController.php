<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoticesRequest;
use App\Http\Requests\UpdateNoticesRequest;
use App\Repositories\NoticesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class NoticesController extends AppBaseController
{
    /** @var  NoticesRepository */
    private $noticesRepository;

    public function __construct(NoticesRepository $noticesRepo)
    {
        $this->noticesRepository = $noticesRepo;
    }

    /**
     * Display a listing of the Notices.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->noticesRepository->pushCriteria(new RequestCriteria($request));
        $notices = $this->noticesRepository->all();

        return view('notices.index')
            ->with('notices', $notices);
    }

    /**
     * Show the form for creating a new Notices.
     *
     * @return Response
     */
    public function create()
    {
        return view('notices.create');
    }

    /**
     * Store a newly created Notices in storage.
     *
     * @param CreateNoticesRequest $request
     *
     * @return Response
     */
    public function store(CreateNoticesRequest $request)
    {
        $input = $request->all();

        $notices = $this->noticesRepository->create($input);

        Flash::success('Notices saved successfully.');

        return redirect(route('notices.index'));
    }

    /**
     * Display the specified Notices.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notices = $this->noticesRepository->findWithoutFail($id);

        if (empty($notices)) {
            Flash::error('Notices not found');

            return redirect(route('notices.index'));
        }

        return view('notices.show')->with('notices', $notices);
    }

    /**
     * Show the form for editing the specified Notices.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notices = $this->noticesRepository->findWithoutFail($id);

        if (empty($notices)) {
            Flash::error('Notices not found');

            return redirect(route('notices.index'));
        }

        return view('notices.edit')->with('notices', $notices);
    }

    /**
     * Update the specified Notices in storage.
     *
     * @param  int              $id
     * @param UpdateNoticesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNoticesRequest $request)
    {
        $notices = $this->noticesRepository->findWithoutFail($id);

        if (empty($notices)) {
            Flash::error('Notices not found');

            return redirect(route('notices.index'));
        }

        $notices = $this->noticesRepository->update($request->all(), $id);

        Flash::success('Notices updated successfully.');

        return redirect(route('notices.index'));
    }

    /**
     * Remove the specified Notices from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notices = $this->noticesRepository->findWithoutFail($id);

        if (empty($notices)) {
            Flash::error('Notices not found');

            return redirect(route('notices.index'));
        }

        $this->noticesRepository->delete($id);

        Flash::success('Notices deleted successfully.');

        return redirect(route('notices.index'));
    }
}
