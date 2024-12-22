<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatedContentEvent;
use App\Events\DeletedContentEvent;
use App\Events\UpdatedContentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use Exception;

class TagController extends Controller
{
    public $title;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * CardController constructor.
     */
    public function __construct(
        TagRepository $tagRepository,
    ) {
        $this->tagRepository = $tagRepository;

        $this->title = trans('general.tags.title');
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
        $items = $this->tagRepository->serverPaginationFilteringFor($request);
        return view('management.tags.index', compact(
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
        return view('management.tags.create', compact(
            'title',
        ));
    }

    /**
     * Store
     */
    public function store(CategoryRequest $request)
    {
        try {
            $item = $this->tagRepository->create($request->all());

            event(new CreatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.tags.index')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.tags.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function destroy(Request $request, $id)
    {
        try {
            $item = $this->tagRepository->findOrFail($id);
            $this->tagRepository->destroy($item);

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
        $item = $this->tagRepository->findOrFail($id);
        return view('management.tags.edit', compact(
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
            $item = $this->tagRepository->findOrFail($id);
            $this->tagRepository->update($item, $request->all());

            event(new UpdatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.tags.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.tags.edit', $id)->with('error', $e->getMessage());
        }
    }
}