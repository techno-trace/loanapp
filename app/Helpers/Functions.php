<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class Functions
{
    public static function logException(Exception $e)
    {
        $template = 'Message: ' . $e->getMessage() . "\n\n" .

        'Type: ' . request()->method() . "\n\n" .

        'Full: ' . url()->full() . "\n\n" .

        'Filename: ' . $e->getFile() . ':' .

        $e->getLine() . "\n\n" .

        'CLN: ' . $e->getLine() . "\n\n";

        $trace = 'Stack Trace: ' .

        $e->getTraceAsString() . "\n\n\n\n";

        Log::info($template . "\n\n\n\n" . $trace);
    }
}
