<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostUserRequest;
use App\Http\Requests\UpdatePostUserRequest;
use App\Repositories\PostUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PostUserController extends AppBaseController
{
    /** @var  PostUserRepository */
    private $postUserRepository;

    public function __construct(PostUserRepository $postUserRepo)
    {
        $this->postUserRepository = $postUserRepo;
    }

    /**
     * Display a listing of the PostUser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->postUserRepository->pushCriteria(new RequestCriteria($request));
        $postUsers = $this->postUserRepository->all();

        return view('post_users.index')
            ->with('postUsers', $postUsers);
    }

    /**
     * Show the form for creating a new PostUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('post_users.create');
    }

    /**
     * Store a newly created PostUser in storage.
     *
     * @param CreatePostUserRequest $request
     *
     * @return Response
     */
    public function store(CreatePostUserRequest $request)
    {
        $input = $request->all();

        $postUser = $this->postUserRepository->create($input);

        Flash::success('Post User saved successfully.');

        return redirect(route('postUsers.index'));
    }

    /**
     * Display the specified PostUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $postUser = $this->postUserRepository->findWithoutFail($id);

        if (empty($postUser)) {
            Flash::error('Post User not found');

            return redirect(route('postUsers.index'));
        }

        return view('post_users.show')->with('postUser', $postUser);
    }

    /**
     * Show the form for editing the specified PostUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $postUser = $this->postUserRepository->findWithoutFail($id);

        if (empty($postUser)) {
            Flash::error('Post User not found');

            return redirect(route('postUsers.index'));
        }

        return view('post_users.edit')->with('postUser', $postUser);
    }

    /**
     * Update the specified PostUser in storage.
     *
     * @param  int              $id
     * @param UpdatePostUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostUserRequest $request)
    {
        $postUser = $this->postUserRepository->findWithoutFail($id);

        if (empty($postUser)) {
            Flash::error('Post User not found');

            return redirect(route('postUsers.index'));
        }

        $postUser = $this->postUserRepository->update($request->all(), $id);

        Flash::success('Post User updated successfully.');

        return redirect(route('postUsers.index'));
    }

    /**
     * Remove the specified PostUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $postUser = $this->postUserRepository->findWithoutFail($id);

        if (empty($postUser)) {
            Flash::error('Post User not found');

            return redirect(route('postUsers.index'));
        }

        $this->postUserRepository->delete($id);

        Flash::success('Post User deleted successfully.');

        return redirect(route('postUsers.index'));
    }
}
