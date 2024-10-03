<?php

namespace App\Supports;

use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class EmailAbstract extends Mailable
{
    use SerializesModels;

    public string $content;

    public $subject;

    public array $data;

    public function __construct(string|null $content, string|null $subject, array $data = [])
    {
        $this->content = $content;
        $this->subject = $subject;
        $this->data = $data;
    }

    public function build(): EmailAbstract
    {

        $fromAddress = config('mail.from.address');

        $fromName = config('mail.from.name');

        if (isset($this->data['from'])) {
            if (is_array($this->data['from'])) {
                $fromAddress = Arr::first(array_keys($this->data['from']));
                $fromName = Arr::first($this->data['from']);
            } else {
                $fromAddress = $this->data['from'];
            }
        }

        $email = $this
            ->from($fromAddress, $fromName)
            ->subject($this->subject)
            ->view('mails.layouts')
            ->with([
                'body' => $this->content,
                'title' => $this->subject,
                'date' => Carbon::now()->format('d/m/Y'),
            ]);

        $attachments = Arr::get($this->data, 'attachments');
        if (! empty($attachments)) {
            if (! is_array($attachments)) {
                $attachments = [$attachments];
            }
            foreach ($attachments as $file) {
                $email->attach($file);
            }
        }

        if (isset($this->data['cc'])) {
            $email = $this->cc($this->data['cc']);
        }

        if (isset($this->data['bcc'])) {
            $email = $this->bcc($this->data['bcc']);
        }

        if (isset($this->data['replyTo'])) {
            $email = $this->replyTo($this->data['replyTo']);
        }

        return $email;
    }
}
