<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('deihealth:status', function (): void {
    $this->info('DeiHealth application is bootstrapped.');
});
