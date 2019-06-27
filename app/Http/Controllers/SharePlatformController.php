<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSharePlatformRequest;
use App\Http\Requests\UpdateSharePlatformRequest;
use App\Repositories\SharePlatformRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SharePlatformController extends AppBaseController
{
    /** @var  SharePlatformRepository */
    private $sharePlatformRepository;

    public function __construct(SharePlatformRepository $sharePlatformRepo)
    {
        $this->sharePlatformRepository = $sharePlatformRepo;
    }

    /**
     * Display a listing of the SharePlatform.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->sharePlatformRepository->pushCriteria(new RequestCriteria($request));

        $sharePlatforms = $this->sharePlatformRepository
        ->orderBy('created_at','desc')->paginate(15);

        return view('share_platforms.index')
            ->with('sharePlatforms', $sharePlatforms);
    }

    /**
     * Show the form for creating a new SharePlatform.
     *
     * @return Response
     */
    public function create()
    {
        return view('share_platforms.create');
    }

    /**
     * Store a newly created SharePlatform in storage.
     *
     * @param CreateSharePlatformRequest $request
     *
     * @return Response
     */
    public function store(CreateSharePlatformRequest $request)
    {
        $input = $request->all();

        $sharePlatform = $this->sharePlatformRepository->model()::create($input);

        $this->generatePlatformErweima($sharePlatform,$request);

        Flash::success('添加成功.');

        return redirect(route('sharePlatforms.index'));
    }

    //生成平台二维码
    private function generatePlatformErweima($platform,$request)
    {
        $input = $request->all();

        $platform->update([
            'qrcode'=>app('common')->generateErweima($request,$request->root().'?platform='.zcjy_base64_en($input['name']),isset($input['size']) ? $input['size'] : 200
        )]);

    }

    /**
     * Display the specified SharePlatform.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sharePlatform = $this->sharePlatformRepository->findWithoutFail($id);

        if (empty($sharePlatform)) {
            Flash::error('Share Platform not found');

            return redirect(route('sharePlatforms.index'));
        }

        return view('share_platforms.show')->with('sharePlatform', $sharePlatform);
    }

    /**
     * Show the form for editing the specified SharePlatform.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sharePlatform = $this->sharePlatformRepository->findWithoutFail($id);

        if (empty($sharePlatform)) {
            Flash::error('Share Platform not found');

            return redirect(route('sharePlatforms.index'));
        }

        return view('share_platforms.edit')->with('sharePlatform', $sharePlatform);
    }

    /**
     * Update the specified SharePlatform in storage.
     *
     * @param  int              $id
     * @param UpdateSharePlatformRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSharePlatformRequest $request)
    {
        $sharePlatform = $this->sharePlatformRepository->findWithoutFail($id);

        if (empty($sharePlatform)) {
            Flash::error('Share Platform not found');

            return redirect(route('sharePlatforms.index'));
        }

        $this->sharePlatformRepository->update($request->all(), $id);

        $this->generatePlatformErweima($sharePlatform,$request);
        
        Flash::success('更新成功.');

        return redirect(route('sharePlatforms.index'));
    }

    /**
     * Remove the specified SharePlatform from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sharePlatform = $this->sharePlatformRepository->findWithoutFail($id);

        if (empty($sharePlatform)) {
            Flash::error('Share Platform not found');

            return redirect(route('sharePlatforms.index'));
        }

        $this->sharePlatformRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('sharePlatforms.index'));
    }
}
