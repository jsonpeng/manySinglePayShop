<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttentionGolRequest;
use App\Http\Requests\UpdateAttentionGolRequest;
use App\Repositories\AttentionGolRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttentionGolController extends AppBaseController
{
    /** @var  AttentionGolRepository */
    private $attentionGolRepository;

    public function __construct(AttentionGolRepository $attentionGolRepo)
    {
        $this->attentionGolRepository = $attentionGolRepo;
    }

    /**
     * Display a listing of the AttentionGol.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attentionGolRepository->pushCriteria(new RequestCriteria($request));
        $attentionGols = $this->attentionGolRepository->all();

        return view('attention_gols.index')
            ->with('attentionGols', $attentionGols);
    }

    /**
     * Show the form for creating a new AttentionGol.
     *
     * @return Response
     */
    public function create()
    {
        return view('attention_gols.create');
    }

    /**
     * Store a newly created AttentionGol in storage.
     *
     * @param CreateAttentionGolRequest $request
     *
     * @return Response
     */
    public function store(CreateAttentionGolRequest $request)
    {
        $input = $request->all();

        $attentionGol = $this->attentionGolRepository->create($input);

        Flash::success('Attention Gol saved successfully.');

        return redirect(route('attentionGols.index'));
    }

    /**
     * Display the specified AttentionGol.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attentionGol = $this->attentionGolRepository->findWithoutFail($id);

        if (empty($attentionGol)) {
            Flash::error('Attention Gol not found');

            return redirect(route('attentionGols.index'));
        }

        return view('attention_gols.show')->with('attentionGol', $attentionGol);
    }

    /**
     * Show the form for editing the specified AttentionGol.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attentionGol = $this->attentionGolRepository->findWithoutFail($id);

        if (empty($attentionGol)) {
            Flash::error('Attention Gol not found');

            return redirect(route('attentionGols.index'));
        }

        return view('attention_gols.edit')->with('attentionGol', $attentionGol);
    }

    /**
     * Update the specified AttentionGol in storage.
     *
     * @param  int              $id
     * @param UpdateAttentionGolRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttentionGolRequest $request)
    {
        $attentionGol = $this->attentionGolRepository->findWithoutFail($id);

        if (empty($attentionGol)) {
            Flash::error('Attention Gol not found');

            return redirect(route('attentionGols.index'));
        }

        $attentionGol = $this->attentionGolRepository->update($request->all(), $id);

        Flash::success('Attention Gol updated successfully.');

        return redirect(route('attentionGols.index'));
    }

    /**
     * Remove the specified AttentionGol from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attentionGol = $this->attentionGolRepository->findWithoutFail($id);

        if (empty($attentionGol)) {
            Flash::error('Attention Gol not found');

            return redirect(route('attentionGols.index'));
        }

        $this->attentionGolRepository->delete($id);

        Flash::success('Attention Gol deleted successfully.');

        return redirect(route('attentionGols.index'));
    }
}
