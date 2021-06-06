<?php

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Find files on a given directory
 * with a given pattern and delete them.
 */
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

function array_sort_numbers(array $numbers)
{
    // count each possible value
    for ($i = 0; $i <= max($numbers); $i++) {
        $counts[$i] = 0;
    }

    // Increment counts of number
    for ($i = 0; $i < count($numbers); $i++) {
        $counts[$numbers[$i]]++;
    }

    // The first placement
    $placement = 0;

    // Iterate each number to find it correct placement
    for ($n = 0; $n <= max($numbers); $n++) {
        // if ($counts[$n]) {
        //     echo PHP_EOL . 'current number: ' . $n;
        // }

        // Iterate each count until the current number
        // If no count for that number is 0, it will be skipped as $i < 0
        for ($i = 0; $i < $counts[$n]; $i++) {
            // echo '/ count: ' . $i;
            // echo ' / placement: ' . $placement;

            // Set placement
            $sorted[$placement] = $n;

            $placement++;
        }
    }

    return $sorted;
}

// Tried a alternative simpler version,
// but it won't work if any number is repeated
function array_sort_numbers_alternative(array $numbers)
{
    for ($i = 0; $i <= max($numbers); $i++) {
        $counts[$i] = 0;
    }

    for ($i = 0; $i < count($numbers); $i++) {
        $counts[$numbers[$i]]++;
    }

    return array_keys(array_filter($counts));
}
