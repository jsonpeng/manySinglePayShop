<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoansRequest;
use App\Http\Requests\UpdateLoansRequest;
use App\Repositories\LoansRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LoansController extends AppBaseController
{
    /** @var  LoansRepository */
    private $loansRepository;

    public function __construct(LoansRepository $loansRepo)
    {
        $this->loansRepository = $loansRepo;
    }

    /**
     * Display a listing of the Loans.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->loansRepository->pushCriteria(new RequestCriteria($request));
        $loans = $this->loansRepository->orderBy('created_at','desc')->paginate(15);

        return view('loans.index')
            ->with('loans', $loans);
    }

    /**
     * Show the form for creating a new Loans.
     *
     * @return Response
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Store a newly created Loans in storage.
     *
     * @param CreateLoansRequest $request
     *
     * @return Response
     */
    public function store(CreateLoansRequest $request)
    {
        $input = $request->all();

        $loans = $this->loansRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('loans.index'));
    }

    /**
     * Display the specified Loans.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loans = $this->loansRepository->findWithoutFail($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        return view('loans.show')->with('loans', $loans);
    }

    /**
     * Show the form for editing the specified Loans.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loans = $this->loansRepository->findWithoutFail($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        return view('loans.edit')->with('loans', $loans);
    }

    /**
     * Update the specified Loans in storage.
     *
     * @param  int              $id
     * @param UpdateLoansRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoansRequest $request)
    {
        $loans = $this->loansRepository->findWithoutFail($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        $loans = $this->loansRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('loans.index'));
    }

    /**
     * Remove the specified Loans from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loans = $this->loansRepository->findWithoutFail($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        $this->loansRepository->delete($id);

        Flash::success('Loans deleted successfully.');

        return redirect(route('loans.index'));
    }
}
