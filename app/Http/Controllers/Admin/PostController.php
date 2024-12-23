<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatedContentEvent;
use App\Events\DeletedContentEvent;
use App\Events\UpdatedContentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Exception;

class PostController extends Controller
{
    public $title;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * CardController constructor.
     */
    public function __construct(
        PostRepository $postRepository,
        TagRepository $tagRepository,
    ) {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;

        $this->title = trans('general.posts.title');
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
        $items = $this->postRepository->serverPaginationFilteringFor($request);
        return view('management.posts.index', compact(
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
        return view('management.posts.create', compact(
            'title',
        ));
    }

    /**
     * Store
     */
    public function store(PostRequest $request)
    {
        try {
            $item = $this->postRepository->create($request->all());
            $this->tagRepository->saveWithPost($item, $request->tags);

            event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.posts.index')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.posts.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function destroy(Request $request, $id)
    {
        try {
            $item = $this->postRepository->findOrFail($id);
            $this->postRepository->destroy($item);

            event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $item));

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
        $item = $this->postRepository->findOrFail($id);
        return view('management.posts.edit', compact(
            'title',
            'item',
        ));
    }

    /**
     * Update
     */
    public function update(PostRequest $request, $id)
    {
        try {
            $item = $this->postRepository->findOrFail($id);
            $this->postRepository->update($item, $request->all());
            $this->tagRepository->saveWithPost($item, $request->tags);

            event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.posts.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.posts.edit', $id)->with('error', $e->getMessage());
        }
    }
}