<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostAttentionRequest;
use App\Http\Requests\UpdatePostAttentionRequest;
use App\Repositories\PostAttentionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PostAttentionController extends AppBaseController
{
    /** @var  PostAttentionRepository */
    private $postAttentionRepository;

    public function __construct(PostAttentionRepository $postAttentionRepo)
    {
        $this->postAttentionRepository = $postAttentionRepo;
    }

    /**
     * Display a listing of the PostAttention.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->postAttentionRepository->pushCriteria(new RequestCriteria($request));
        $postAttentions = $this->postAttentionRepository->all();

        return view('post_attentions.index')
            ->with('postAttentions', $postAttentions);
    }

    /**
     * Show the form for creating a new PostAttention.
     *
     * @return Response
     */
    public function create()
    {
        return view('post_attentions.create');
    }

    /**
     * Store a newly created PostAttention in storage.
     *
     * @param CreatePostAttentionRequest $request
     *
     * @return Response
     */
    public function store(CreatePostAttentionRequest $request)
    {
        $input = $request->all();

        $postAttention = $this->postAttentionRepository->create($input);

        Flash::success('Post Attention saved successfully.');

        return redirect(route('postAttentions.index'));
    }

    /**
     * Display the specified PostAttention.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $postAttention = $this->postAttentionRepository->findWithoutFail($id);

        if (empty($postAttention)) {
            Flash::error('Post Attention not found');

            return redirect(route('postAttentions.index'));
        }

        return view('post_attentions.show')->with('postAttention', $postAttention);
    }

    /**
     * Show the form for editing the specified PostAttention.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $postAttention = $this->postAttentionRepository->findWithoutFail($id);

        if (empty($postAttention)) {
            Flash::error('Post Attention not found');

            return redirect(route('postAttentions.index'));
        }

        return view('post_attentions.edit')->with('postAttention', $postAttention);
    }

    /**
     * Update the specified PostAttention in storage.
     *
     * @param  int              $id
     * @param UpdatePostAttentionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostAttentionRequest $request)
    {
        $postAttention = $this->postAttentionRepository->findWithoutFail($id);

        if (empty($postAttention)) {
            Flash::error('Post Attention not found');

            return redirect(route('postAttentions.index'));
        }

        $postAttention = $this->postAttentionRepository->update($request->all(), $id);

        Flash::success('Post Attention updated successfully.');

        return redirect(route('postAttentions.index'));
    }

    /**
     * Remove the specified PostAttention from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $postAttention = $this->postAttentionRepository->findWithoutFail($id);

        if (empty($postAttention)) {
            Flash::error('Post Attention not found');

            return redirect(route('postAttentions.index'));
        }

        $this->postAttentionRepository->delete($id);

        Flash::success('Post Attention deleted successfully.');

        return redirect(route('postAttentions.index'));
    }
}
