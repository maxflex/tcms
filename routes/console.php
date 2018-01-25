<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('generate:version_control', function () {
    \App\Service\VersionControl::generate();
})->describe('Generate version control table');

Artisan::command('version:increase', function () {
    \App\Service\Settings::set('version', uniqid());
})->describe('Generate version control table');

Artisan::command('generate:version_control_both', function () {
    $this->line("\n************** RE-GENERATE PRODUCTION TABLE ************** \n");
    shell_exec('envoy run generate:version_control');

    $this->line("\n************** RE-GENERATE LOCALHOST TABLE ************** \n");
    shell_exec('php artisan generate:version_control');
})->describe('Generate version control table');

Artisan::command('vars:not_used', function () {
    $variable_names = \App\Models\Variable::pluck('name');
    foreach($variable_names as $variable_name) {
        $vars = \DB::table('variables')->whereRaw("html LIKE '%[{$variable_name}%'")->exists();
        $pages = \DB::table('pages')->whereRaw("html LIKE '%[{$variable_name}%' OR html_mobile LIKE '%[{$variable_name}%'")->exists();
        $faqs = \DB::table('faqs')->whereRaw("answer LIKE '%[{$variable_name}%'")->exists();
        if (!$vars && !$pages && !$faqs) {
            $this->error($variable_name);
        }
    }
})->describe('Generate version control table');