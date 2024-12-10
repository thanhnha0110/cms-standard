<?php

namespace App\Http\Controllers\Admin;

use App\Events\UpdatedContentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplateRequest;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\LogRepository;
use Exception;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public $title;

    /**
     * @var LogRepository
     */
    private $emailTemplateRepository;

    /**
     * LogController constructor.
     */
    public function __construct(
        EmailTemplateRepository $emailTemplateRepository,
    ) {
        $this->emailTemplateRepository = $emailTemplateRepository;
        $this->title = trans('general.settings.email.form.templates');
    }


    /**
     * Get edit
     */
    public function edit($id)
    {
        $title = $this->title;
        $item = $this->emailTemplateRepository->findOrFail($id);
        return view('settings.email-template', compact(
            'title',
            'item',
        ));
    }


    /**
     * Update
     */
    public function update(EmailTemplateRequest $request, $id)
    {
        try {
            $item = $this->emailTemplateRepository->findOrFail($id);
            $this->emailTemplateRepository->update($item, $request->all());

            event(new UpdatedContentEvent(EMAIL_TEMPLATE_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('settings.email.templates.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('settings.email.templates.edit', $id)->with('error', $e->getMessage());
        }
    }
}