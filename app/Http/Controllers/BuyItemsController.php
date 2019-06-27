<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBuyItemsRequest;
use App\Http\Requests\UpdateBuyItemsRequest;
use App\Repositories\BuyItemsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BuyItemsController extends AppBaseController
{
    /** @var  BuyItemsRepository */
    private $buyItemsRepository;

    public function __construct(BuyItemsRepository $buyItemsRepo)
    {
        $this->buyItemsRepository = $buyItemsRepo;
    }

    /**
     * Display a listing of the BuyItems.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->buyItemsRepository->pushCriteria(new RequestCriteria($request));
        $buyItems = $this->buyItemsRepository->all();

        return view('buy_items.index')
            ->with('buyItems', $buyItems);
    }

    /**
     * Show the form for creating a new BuyItems.
     *
     * @return Response
     */
    public function create()
    {
        return view('buy_items.create');
    }

    /**
     * Store a newly created BuyItems in storage.
     *
     * @param CreateBuyItemsRequest $request
     *
     * @return Response
     */
    public function store(CreateBuyItemsRequest $request)
    {
        $input = $request->all();

        $buyItems = $this->buyItemsRepository->create($input);

        Flash::success('Buy Items saved successfully.');

        return redirect(route('buyItems.index'));
    }

    /**
     * Display the specified BuyItems.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $buyItems = $this->buyItemsRepository->findWithoutFail($id);

        if (empty($buyItems)) {
            Flash::error('Buy Items not found');

            return redirect(route('buyItems.index'));
        }

        return view('buy_items.show')->with('buyItems', $buyItems);
    }

    /**
     * Show the form for editing the specified BuyItems.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $buyItems = $this->buyItemsRepository->findWithoutFail($id);

        if (empty($buyItems)) {
            Flash::error('Buy Items not found');

            return redirect(route('buyItems.index'));
        }

        return view('buy_items.edit')->with('buyItems', $buyItems);
    }

    /**
     * Update the specified BuyItems in storage.
     *
     * @param  int              $id
     * @param UpdateBuyItemsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBuyItemsRequest $request)
    {
        $buyItems = $this->buyItemsRepository->findWithoutFail($id);

        if (empty($buyItems)) {
            Flash::error('Buy Items not found');

            return redirect(route('buyItems.index'));
        }

        $buyItems = $this->buyItemsRepository->update($request->all(), $id);

        Flash::success('Buy Items updated successfully.');

        return redirect(route('buyItems.index'));
    }

    /**
     * Remove the specified BuyItems from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $buyItems = $this->buyItemsRepository->findWithoutFail($id);

        if (empty($buyItems)) {
            Flash::error('Buy Items not found');

            return redirect(route('buyItems.index'));
        }

        $this->buyItemsRepository->delete($id);

        Flash::success('Buy Items deleted successfully.');

        return redirect(route('buyItems.index'));
    }
}
