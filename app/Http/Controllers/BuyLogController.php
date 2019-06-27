<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBuyLogRequest;
use App\Http\Requests\UpdateBuyLogRequest;
use App\Repositories\BuyLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BuyLogController extends AppBaseController
{
    /** @var  BuyLogRepository */
    private $buyLogRepository;

    public function __construct(BuyLogRepository $buyLogRepo)
    {
        $this->buyLogRepository = $buyLogRepo;
    }

    /**
     * Display a listing of the BuyLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->buyLogRepository->pushCriteria(new RequestCriteria($request));

        $input = filterNullInput($request->all());

        $buyLogs = $this->buyLogRepository->model()::where('id','>',0);

        if(array_key_exists('pay_status', $input))
        {
            $buyLogs = $buyLogs->where('pay_status',$input['pay_status']);
        }

        if(array_key_exists('name', $input))
        {
            $buyLogs = $buyLogs->where('name','like','%'.$input['name'].'%');
        }

        if(array_key_exists('address', $input))
        {
            $buyLogs = $buyLogs->where('address','like','%'.$input['address'].'%');
        }


        if(array_key_exists('pay_platform', $input))
        {
            $buyLogs = $buyLogs->where('pay_platform',$input['pay_platform']);
        }


        $buyLogs = $buyLogs->orderBy('created_at','desc')->paginate(15);

        return view('buy_logs.index')
            ->with('buyLogs', $buyLogs)
            ->with('input',$input);
    }

    /**
     * Show the form for creating a new BuyLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('buy_logs.create');
    }

    /**
     * Store a newly created BuyLog in storage.
     *
     * @param CreateBuyLogRequest $request
     *
     * @return Response
     */
    public function store(CreateBuyLogRequest $request)
    {
        $input = $request->all();

        $buyLog = $this->buyLogRepository->create($input);

        Flash::success('Buy Log saved successfully.');

        return redirect(route('buyLogs.index'));
    }

    /**
     * Display the specified BuyLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $buyLog = $this->buyLogRepository->findWithoutFail($id);

        if (empty($buyLog)) {
            Flash::error('Buy Log not found');

            return redirect(route('buyLogs.index'));
        }

        return view('buy_logs.show')->with('buyLog', $buyLog);
    }

    /**
     * Show the form for editing the specified BuyLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $buyLog = $this->buyLogRepository->findWithoutFail($id);

        if (empty($buyLog)) {
            Flash::error('Buy Log not found');

            return redirect(route('buyLogs.index'));
        }

        return view('buy_logs.edit')->with('buyLog', $buyLog);
    }

    /**
     * Update the specified BuyLog in storage.
     *
     * @param  int              $id
     * @param UpdateBuyLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBuyLogRequest $request)
    {
        $buyLog = $this->buyLogRepository->findWithoutFail($id);

        if (empty($buyLog)) {
            Flash::error('Buy Log not found');

            return redirect(route('buyLogs.index'));
        }

        $buyLog = $this->buyLogRepository->update($request->all(), $id);

        Flash::success('Buy Log updated successfully.');

        return redirect(route('buyLogs.index'));
    }

    /**
     * Remove the specified BuyLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $buyLog = $this->buyLogRepository->findWithoutFail($id);

        if (empty($buyLog)) 
        {
            Flash::error('Buy Log not found');

            return redirect(route('buyLogs.index'));
        }

        $this->buyLogRepository->delete($id);

        #订单删除后把item一起清除
        app('common')->BuyItemsRepo()->deleteLogItems($id);

        Flash::success('删除成功.');

        return redirect(route('buyLogs.index'));
    }
}
