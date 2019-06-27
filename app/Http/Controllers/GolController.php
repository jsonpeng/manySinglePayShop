<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGolRequest;
use App\Http\Requests\UpdateGolRequest;
use App\Repositories\GolRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GolController extends AppBaseController
{
    /** @var  GolRepository */
    private $golRepository;

    public function __construct(GolRepository $golRepo)
    {
        $this->golRepository = $golRepo;
    }

    /**
     * Display a listing of the Gol.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->golRepository->pushCriteria(new RequestCriteria($request));
        $gols = descAndPaginateToShow($this->golRepository);

        return view('gols.index')
            ->with('gols', $gols);
    }

    /**
     * Show the form for creating a new Gol.
     *
     * @return Response
     */
    public function create()
    {
        return view('gols.create');
    }

    /**
     * Store a newly created Gol in storage.
     *
     * @param CreateGolRequest $request
     *
     * @return Response
     */
    public function store(CreateGolRequest $request)
    {
        $input = $request->all();

        $gol = $this->golRepository->create($input);

        Flash::success('Gol saved successfully.');

        return redirect(route('gols.index'));
    }

    /**
     * Display the specified Gol.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gol = $this->golRepository->findWithoutFail($id);

        if (empty($gol)) {
            Flash::error('Gol not found');

            return redirect(route('gols.index'));
        }

        return view('gols.show')->with('gol', $gol);
    }

    /**
     * Show the form for editing the specified Gol.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gol = $this->golRepository->findWithoutFail($id);

        if (empty($gol)) {
            Flash::error('Gol not found');

            return redirect(route('gols.index'));
        }
        $services = app('common')->golServicesRepo()->all();
        return view('gols.edit')
        ->with('gol', $gol)
        ->with('services',$services);
    }

    /**
     * Update the specified Gol in storage.
     *
     * @param  int              $id
     * @param UpdateGolRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGolRequest $request)
    {
        $gol = $this->golRepository->findWithoutFail($id);
        $input = $request->all();
        if (empty($gol)) {
            Flash::error('Gol not found');

            return redirect(route('gols.index'));
        }

        if(array_key_exists('services',$input)){
          #处理空格和换行符
          $input['services'] = preg_replace("/\r\n|\s+/",'',$input['services']);
        }
        $this->golRepository->update($input, $id);

        Flash::success('更新成功.');

        if($input['publish_status'] == '0'){
            $input['publish_status'] = '审核中';
        }
        elseif($input['publish_status'] == '1'){
              $input['publish_status'] = '已发布';
        }
        else{
             $input['publish_status'] = '已下架';
        }

        if(array_key_exists('tui', $input)){

            app('notice')->sendNoticeToUser($gol->user_id,'您的gol小屋'.tag($input['name'],'orange').'状态已更新为'.tag($input['publish_status']));

        }

        return redirect(route('gols.index'));
    }

    /**
     * Remove the specified Gol from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gol = $this->golRepository->findWithoutFail($id);

        if (empty($gol)) {
            Flash::error('Gol not found');

            return redirect(route('gols.index'));
        }

        $this->golRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('gols.index'));
    }
}
