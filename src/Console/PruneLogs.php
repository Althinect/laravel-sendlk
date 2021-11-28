<?php

namespace Althinect\LaravelSendlk\Console;

use Althinect\LaravelSendlk\Models\MessageLog;
use Illuminate\Console\Command;

class PruneLogs extends Command
{
    protected $signature = 'laravel-sendlk:prune 
                            {--only-successful-logs : Delete only successful logs} 
                            {--only-errors} : Delete only error logs';

    protected $description = 'Prune message log of Laravel SendLK package';

    public function handle()
    {
        $this->info('Pruning message logs!');
        if ($this->option('only-successful-logs') && $this->options('only-errors')) {
            MessageLog::truncate();
            $this->info('All message logs pruned!');
        } else if ($this->option('only-successful-logs')) {
            MessageLog::where('success', true)->delete();
            $this->info('Successful message logs pruned!');
        } else if ($this->option('only-errors')) {
            MessageLog::where('success', false)->delete();
            $this->info('Error message logs pruned!');
        } else {
            MessageLog::truncate();
            $this->info('All message logs pruned!');
        }
    }
}