<?php

namespace App\Mail;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImageEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $imagePath;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $imagePath
     * @param Business $user
     */
    public function __construct($imagePath, Business $user)
    {
        $this->imagePath = $imagePath;
        $this->user = $user;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.test');
    }
}
