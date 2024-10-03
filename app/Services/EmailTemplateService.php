<?php

namespace App\Services;

use App\Supports\EmailAbstract;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;

class EmailTemplateService extends BaseService
{

    protected string|null $template = null;
    protected array $variableValues = [];
    protected array $args = [];

    public function __construct(protected Mailer $mailer)
    {
    }

    /**
     * Upload file from request
     * @param $request
     * @return array|null
     */
    public function sendUsingTemplate(
        string $template,
        string|array|null $email = null,
        array $args = [],
        $subject = null
    ): bool {

        $this->template = $template;
        $this->args = $args;

        if (! $subject) {
            $subject = $this->getSubject();
        }

        $this->send($this->getContent(), $subject, $email, $args);

        return true;
    }

    public function send(
        string $content,
        string $subject,
        string $to,
        array $args = [],
    ): void {
        try {
            $content = $this->prepareData($content);
            $subject = $this->prepareData($subject);

            $this->mailer->to($to)->send(new EmailAbstract($content, $subject, $args));
        } catch (Exception $e) {
            Log::error('Mailer: ' . $e->getMessage());
        }
    }

    public function getContent(): string
    {
        return $this->prepareData($this->getAttrOfTemplate($this->template, 'body'));
    }

    public function getSubject(): string
    {
        return $this->prepareData($this->getAttrOfTemplate($this->template, 'subject'));
    }

    public function getAttrOfTemplate(string $template, $attr): string
    {
        return '';
    }

    public function prepareData(string $content): string
    {
        $this->initVariableValues();

        if (! empty($content)) {
            $content = $this->replaceVariableValue($content);
        }

        return $content;
    }

    public function initVariableValues(): void
    {
        $now = Carbon::now();
        $init = [
            'site_title' => config('app.name'),
            'site_url' => url(''),
            'date_time' => $now->toDateTimeString(),
            'date_year' => $now->year,
            'now' => $now,
        ];
        $this->variableValues = array_merge($init, $this->args);
    }

    protected function replaceVariableValue(string $content): string
    {
        foreach ($this->variableValues as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }

        return $content;
    }
}