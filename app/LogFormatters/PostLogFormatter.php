<?php

namespace App\LogFormatters;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class PostLogFormatter
{
    /**
     * Customize the given logger instance.
     */
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                '[%datetime%] %channel%.%level_name%: %message% %context% %extra%' . PHP_EOL
            ));
        }
    }
}
