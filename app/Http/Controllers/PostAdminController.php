<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostAdminRequest;
use App\Http\Requests\UpdatePostAdminRequest;
use App\Repositories\PostAdminRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PostAdminController extends AppBaseController
{
    /** @var  PostAdminRepository */
    private $postAdminRepository;

    public function __construct(PostAdminRepository $postAdminRepo)
    {
        $this->postAdminRepository = $postAdminRepo;
    }

    /**
     * Display a listing of the PostAdmin.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->postAdminRepository->pushCriteria(new RequestCriteria($request));
        $postAdmins = $this->postAdminRepository->all();

        return view('post_admins.index')
            ->with('postAdmins', $postAdmins);
    }

    /**
     * Show the form for creating a new PostAdmin.
     *
     * @return Response
     */
    public function create()
    {
        return view('post_admins.create');
    }

    /**
     * Store a newly created PostAdmin in storage.
     *
     * @param CreatePostAdminRequest $request
     *
     * @return Response
     */
    public function store(CreatePostAdminRequest $request)
    {
        $input = $request->all();

        $postAdmin = $this->postAdminRepository->create($input);

        Flash::success('Post Admin saved successfully.');

        return redirect(route('postAdmins.index'));
    }

    /**
     * Display the specified PostAdmin.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $postAdmin = $this->postAdminRepository->findWithoutFail($id);

        if (empty($postAdmin)) {
            Flash::error('Post Admin not found');

            return redirect(route('postAdmins.index'));
        }

        return view('post_admins.show')->with('postAdmin', $postAdmin);
    }

    /**
     * Show the form for editing the specified PostAdmin.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $postAdmin = $this->postAdminRepository->findWithoutFail($id);

        if (empty($postAdmin)) {
            Flash::error('Post Admin not found');

            return redirect(route('postAdmins.index'));
        }

        return view('post_admins.edit')->with('postAdmin', $postAdmin);
    }

    /**
     * Update the specified PostAdmin in storage.
     *
     * @param  int              $id
     * @param UpdatePostAdminRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostAdminRequest $request)
    {
        $postAdmin = $this->postAdminRepository->findWithoutFail($id);

        if (empty($postAdmin)) {
            Flash::error('Post Admin not found');

            return redirect(route('postAdmins.index'));
        }

        $postAdmin = $this->postAdminRepository->update($request->all(), $id);

        Flash::success('Post Admin updated successfully.');

        return redirect(route('postAdmins.index'));
    }

    /**
     * Remove the specified PostAdmin from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $postAdmin = $this->postAdminRepository->findWithoutFail($id);

        if (empty($postAdmin)) {
            Flash::error('Post Admin not found');

            return redirect(route('postAdmins.index'));
        }

        $this->postAdminRepository->delete($id);

        Flash::success('Post Admin deleted successfully.');

        return redirect(route('postAdmins.index'));
    }
}
