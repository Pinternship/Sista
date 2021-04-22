<?php

namespace App\Mail;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job_id)
    {
        $this->data = $job_id;
        $this->job = Job::find($job_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Internship application notification')->markdown('emails.acceptmail');
    }
}
