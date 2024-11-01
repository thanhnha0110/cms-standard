<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatedContentEvent;
use App\Events\DeletedContentEvent;
use App\Events\UpdatedContentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use Exception;
use Spatie\Permission\Models\Role;

class CategoryController extends Controller
{
    public $title;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CardController constructor.
     */
    public function __construct(
        CategoryRepository $categoryRepository,
    ) {
        $this->categoryRepository = $categoryRepository;

        $this->title = trans('general.categories.title');
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
        $items = $this->categoryRepository->serverPaginationFilteringFor($request);
        return view('management.categories.index', compact(
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
        return view('management.categories.create', compact(
            'title',
        ));
    }

    /**
     * Store
     */
    public function store(CategoryRequest $request)
    {
        try {
            $item = $this->categoryRepository->create($request->all());

            event(new CreatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.categories.index')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.categories.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function destroy(Request $request, $id)
    {
        try {
            $item = $this->categoryRepository->findOrFail($id);
            $this->categoryRepository->destroy($item);

            event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $item));

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
        $item = $this->categoryRepository->findOrFail($id);
        return view('management.categories.edit', compact(
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
            $item = $this->categoryRepository->findOrFail($id);
            $this->categoryRepository->update($item, $request->all());

            event(new UpdatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('management.categories.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('management.categories.edit', $id)->with('error', $e->getMessage());
        }
    }
}