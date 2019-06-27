<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachPostCommentRequest;
use App\Http\Requests\UpdateAttachPostCommentRequest;
use App\Repositories\AttachPostCommentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttachPostCommentController extends AppBaseController
{
    /** @var  AttachPostCommentRepository */
    private $attachPostCommentRepository;

    public function __construct(AttachPostCommentRepository $attachPostCommentRepo)
    {
        $this->attachPostCommentRepository = $attachPostCommentRepo;
    }

    /**
     * Display a listing of the AttachPostComment.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attachPostCommentRepository->pushCriteria(new RequestCriteria($request));
        $attachPostComments = $this->attachPostCommentRepository->all();

        return view('attach_post_comments.index')
            ->with('attachPostComments', $attachPostComments);
    }

    /**
     * Show the form for creating a new AttachPostComment.
     *
     * @return Response
     */
    public function create()
    {
        return view('attach_post_comments.create');
    }

    /**
     * Store a newly created AttachPostComment in storage.
     *
     * @param CreateAttachPostCommentRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachPostCommentRequest $request)
    {
        $input = $request->all();

        $attachPostComment = $this->attachPostCommentRepository->create($input);

        Flash::success('Attach Post Comment saved successfully.');

        return redirect(route('attachPostComments.index'));
    }

    /**
     * Display the specified AttachPostComment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachPostComment = $this->attachPostCommentRepository->findWithoutFail($id);

        if (empty($attachPostComment)) {
            Flash::error('Attach Post Comment not found');

            return redirect(route('attachPostComments.index'));
        }

        return view('attach_post_comments.show')->with('attachPostComment', $attachPostComment);
    }

    /**
     * Show the form for editing the specified AttachPostComment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachPostComment = $this->attachPostCommentRepository->findWithoutFail($id);

        if (empty($attachPostComment)) {
            Flash::error('Attach Post Comment not found');

            return redirect(route('attachPostComments.index'));
        }

        return view('attach_post_comments.edit')->with('attachPostComment', $attachPostComment);
    }

    /**
     * Update the specified AttachPostComment in storage.
     *
     * @param  int              $id
     * @param UpdateAttachPostCommentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachPostCommentRequest $request)
    {
        $attachPostComment = $this->attachPostCommentRepository->findWithoutFail($id);

        if (empty($attachPostComment)) {
            Flash::error('Attach Post Comment not found');

            return redirect(route('attachPostComments.index'));
        }

        $attachPostComment = $this->attachPostCommentRepository->update($request->all(), $id);

        Flash::success('Attach Post Comment updated successfully.');

        return redirect(route('attachPostComments.index'));
    }

    /**
     * Remove the specified AttachPostComment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachPostComment = $this->attachPostCommentRepository->findWithoutFail($id);

        if (empty($attachPostComment)) {
            Flash::error('Attach Post Comment not found');

            return redirect(route('attachPostComments.index'));
        }

        $this->attachPostCommentRepository->delete($id);

        Flash::success('Attach Post Comment deleted successfully.');

        return redirect(route('attachPostComments.index'));
    }
}
