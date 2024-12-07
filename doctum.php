<?php
use Doctum\Doctum;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in('app');

return new Doctum($iterator, [
    'title' => 'Documentación del Sistema de Gym Manager Pro',
    'source_dir' => 'app',
    'build_dir' => 'docs/api',
    'cache_dir' => 'docs/cache',
    'default_opened_level' => 2,
]);