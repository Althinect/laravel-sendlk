<?php

namespace Althinect\LaravelSendlk\Console;

use Althinect\LaravelSendlk\Models\MessageLog;
use Illuminate\Console\Command;

class PruneLogs extends Command
{
    protected $signature = 'laravel-sendlk:prune';

    protected $description = 'Prune message log of Laravel SendLK package';

    public function handle()
    {
        $this->info('Pruning all message logs!');
        MessageLog::truncate();
        $this->info('All message logs pruned!');
    }
}