<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatedContentEvent;
use App\Events\DeletedContentEvent;
use App\Events\UpdatedContentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use Exception;

class CommentController extends Controller
{
    public $title;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * CardController constructor.
     */
    public function __construct(
        CommentRepository $commentRepository,
    ) {
        $this->commentRepository = $commentRepository;

        $this->title = trans('general.comments.title');
    }


    /**
     * Get and paginate all users
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->commentRepository->serverPaginationFilteringFor($request);
        return view('management.comments.index', compact(
            'title',
            'page',
            'size',
            'search',
            'items',
        ));
    }

    /**
     * Create
     */
    public function create()
    {
        $title = $this->title;
        return view('management.comments.create', compact(
            'title',
        ));
    }

    /**
     * Store
     */
    public function store(CategoryRequest $request)
    {
        try {
            $item = $this->commentRepository->create($request->all());

            event(new CreatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.comments.index')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.comments.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function destroy(Request $request, $id)
    {
        try {
            $item = $this->commentRepository->findOrFail($id);
            $this->commentRepository->destroy($item);

            event(new DeletedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $item));

            return $this->success(trans('notices.delete_success_message'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get edit
     */
    public function edit($id)
    {
        $title = $this->title;
        $item = $this->commentRepository->findOrFail($id);
        return view('management.comments.edit', compact(
            'title',
            'item',
        ));
    }

    /**
     * Update
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $item = $this->commentRepository->findOrFail($id);
            $this->commentRepository->update($item, $request->all());

            event(new UpdatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.comments.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.comments.edit', $id)->with('error', $e->getMessage());
        }
    }

    /**
     * Get reply
     */
    public function reply(CommentRequest $request)
    {
        try {
            $comment = $this->commentRepository->findOrFail($request->id);
            $reply = $this->commentRepository->reply($comment, $request);
            return redirect()->route('management.comments.index')->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.comments.index')->with('error', $e->getMessage());
        }
    }
}