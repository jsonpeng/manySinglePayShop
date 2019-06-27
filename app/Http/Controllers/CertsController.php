<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCertsRequest;
use App\Http\Requests\UpdateCertsRequest;
use App\Repositories\CertsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CertsController extends AppBaseController
{
    /** @var  CertsRepository */
    private $certsRepository;

    public function __construct(CertsRepository $certsRepo)
    {
        $this->certsRepository = $certsRepo;
    }

    /**
     * Display a listing of the Certs.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->certsRepository->pushCriteria(new RequestCriteria($request));
        
        $certs = $this->certsRepository->orderBy('created_at','desc')->paginate(15);

        return view('admin.certs.index')
            ->with('certs', $certs);
    }

    /**
     * Show the form for creating a new Certs.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.certs.create');
    }

    /**
     * Store a newly created Certs in storage.
     *
     * @param CreateCertsRequest $request
     *
     * @return Response
     */
    public function store(CreateCertsRequest $request)
    {
        $input = $request->all();

        $certs = $this->certsRepository->create($input);

        Flash::success('Certs saved successfully.');

        return redirect(route('certs.index'));
    }

    /**
     * Display the specified Certs.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $certs = $this->certsRepository->findWithoutFail($id);

        if (empty($certs)) {
            Flash::error('Certs not found');

            return redirect(route('certs.index'));
        }

        return view('certs.show')->with('certs', $certs);
    }

    /**
     * Show the form for editing the specified Certs.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $certs = $this->certsRepository->findWithoutFail($id);

        if (empty($certs)) {
            Flash::error('Certs not found');

            return redirect(route('certs.index'));
        }

        return view('admin.certs.edit')->with('certs', $certs);
    }

    /**
     * Update the specified Certs in storage.
     *
     * @param  int              $id
     * @param UpdateCertsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCertsRequest $request)
    {
        $certs = $this->certsRepository->findWithoutFail($id);

        if (empty($certs)) {
            Flash::error('Certs not found');

            return redirect(route('certs.index'));
        }
        $input = $request->all();

        if($certs->status != $input['status'])
        {
             app('notice')->sendNoticeToUser($certs->user_id,'您的认证状态已更新为'.$input['status']);
        }

       $this->certsRepository->update($input, $id);

        #审核通过更改姓名
        if($input['status'] == '已通过'){
            $user = $certs->user;
            if(!empty($user)){
                $user->update(['name'=>$certs->id_card_name]);
            }
        }

        Flash::success('更新成功.');

        return redirect(route('certs.index'));
    }

    /**
     * Remove the specified Certs from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $certs = $this->certsRepository->findWithoutFail($id);

        if (empty($certs)) {
            Flash::error('Certs not found');

            return redirect(route('certs.index'));
        }

        $this->certsRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('certs.index'));
    }
}
