<?php

namespace App;

class Alert
{
    public $message;
    public $type;

    public function __construct(string $message, string $type = null)
    {
        $this->message = $message;
        $this->type = $type ?? 'success';
    }
}
