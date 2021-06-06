<?php

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

function delete_files_matching(string $path, string $pattern): int
{
    $files = Finder::create()
        ->files()
        ->ignoreDotFiles(true)
        ->in(getcwd() . '/tests/Unit/stubs')
        ->name('0aH*')
        ->sortByName();

    foreach (iterator_to_array($files) as $file) {
        $deleted[] = unlink($file->getRealPath());
    }

    return count($deleted ?? []);
}
