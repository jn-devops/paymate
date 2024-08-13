<?php

namespace Homeful\Paymate\Commands;

use Illuminate\Console\Command;

class PaymateCommand extends Command
{
    public $signature = 'paymate';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
