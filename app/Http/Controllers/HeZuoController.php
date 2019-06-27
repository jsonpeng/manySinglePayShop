<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHeZuoRequest;
use App\Http\Requests\UpdateHeZuoRequest;
use App\Repositories\HeZuoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class HeZuoController extends AppBaseController
{
    /** @var  HeZuoRepository */
    private $heZuoRepository;

    public function __construct(HeZuoRepository $heZuoRepo)
    {
        $this->heZuoRepository = $heZuoRepo;
    }

    /**
     * Display a listing of the HeZuo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->heZuoRepository->pushCriteria(new RequestCriteria($request));
        $heZuos = $this->heZuoRepository->orderBy('created_at','desc')->paginate(15);

        return view('he_zuos.index')
            ->with('heZuos', $heZuos);
    }

    /**
     * Show the form for creating a new HeZuo.
     *
     * @return Response
     */
    public function create()
    {
        return view('he_zuos.create');
    }

    /**
     * Store a newly created HeZuo in storage.
     *
     * @param CreateHeZuoRequest $request
     *
     * @return Response
     */
    public function store(CreateHeZuoRequest $request)
    {
        $input = $request->all();

        $heZuo = $this->heZuoRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('heZuos.index'));
    }

    /**
     * Display the specified HeZuo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $heZuo = $this->heZuoRepository->findWithoutFail($id);

        if (empty($heZuo)) {
            Flash::error('He Zuo not found');

            return redirect(route('heZuos.index'));
        }

        return view('he_zuos.show')->with('heZuo', $heZuo);
    }

    /**
     * Show the form for editing the specified HeZuo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $heZuo = $this->heZuoRepository->findWithoutFail($id);

        if (empty($heZuo)) {
            Flash::error('He Zuo not found');

            return redirect(route('heZuos.index'));
        }

        return view('he_zuos.edit')->with('heZuo', $heZuo);
    }

    /**
     * Update the specified HeZuo in storage.
     *
     * @param  int              $id
     * @param UpdateHeZuoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHeZuoRequest $request)
    {
        $heZuo = $this->heZuoRepository->findWithoutFail($id);

        if (empty($heZuo)) {
            Flash::error('He Zuo not found');

            return redirect(route('heZuos.index'));
        }

        $heZuo = $this->heZuoRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('heZuos.index'));
    }

    /**
     * Remove the specified HeZuo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $heZuo = $this->heZuoRepository->findWithoutFail($id);

        if (empty($heZuo)) {
            Flash::error('He Zuo not found');

            return redirect(route('heZuos.index'));
        }

        $this->heZuoRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('heZuos.index'));
    }
}
