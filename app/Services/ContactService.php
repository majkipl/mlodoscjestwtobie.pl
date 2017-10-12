<?php

namespace App\Services;

use App\Mails\ApplicationMail;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    /**
     * @param string $email
     * @param array $data
     * @return void
     */
    public function sendMail(string $email, array $data): void
    {
        Mail::to($email)->send(new ApplicationMail($data, 'emails.contact.html', 'emails.contact.text'));
    }
}
