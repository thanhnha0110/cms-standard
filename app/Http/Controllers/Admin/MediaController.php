<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatedContentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Repositories\MediaFileRepository;
use App\Services\MediaFileService;
use Exception;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public $title;

    /**
     * @var MediaFileRepository
     */
    private $mediaFileRepository;

    /**
     * @var MediaFileService
     */
    private $mediaFileService;

    /**
     * MediaController constructor.
     */
    public function __construct(
        MediaFileRepository $mediaFileRepository,
        MediaFileService $mediaFileService,
    ) {
        $this->mediaFileRepository = $mediaFileRepository;
        $this->mediaFileService = $mediaFileService;
        $this->title = trans('general.media.title');
    }


    /**
     * Create
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $items = $this->mediaFileRepository->serverPaginationFilteringFor($request);
        return view('media.index', compact(
            'title',
            'items',
        ));
    }

    /**
     * Store
     */
    public function store(MediaRequest $request)
    {
        try {
            $data = $this->mediaFileService->upload($request->file('image'));
            $item = $this->mediaFileRepository->create($data);

            event(new CreatedContentEvent(MEDIA_FILE_MODULE_SCREEN_NAME, $request, $item));

            return $this->success(trans('notices.upload_image_success_message'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getImages(Request $request)
    {
        $images = $this->mediaFileRepository->serverPaginationFilteringFor($request);
        $formattedImages = $images->map(function ($image) {
            return [
                'name' => $image->name,
                'url' => $image->url,
                'created_at' => format_datetime($image->created_at),
                'alt' => $image->alt,
            ];
        });

        return $this->success([
            'items' => $formattedImages,
            'next_page' => $images->currentPage() < $images->lastPage() ? $images->currentPage() + 1 : null,
        ]);
    }
}