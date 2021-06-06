<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Test helpers defined on app\helpers.php
 */
class HelperTest extends TestCase
{
    /**
     * Test find files begining with "0aH" and delete them
     */
    public function testDeleteFilesMatching()
    {
        $files = rand(500, 9999);

        $path = getcwd() . '/tests/Unit/stubs';
        $directories = ['a', 'b', 'c'];
        $extensions = ['', '.txt', '.php', '.md'];

        for ($i = 0; $i < $files; $i++) {
            touch("{$path}/{$directories[array_rand($directories)]}/0aH$i{$extensions[array_rand($extensions)]}");
        }

        $deleted = delete_files_matching($path, '0aH*');

        $this->assertEquals($files, $deleted);
    }

    public function testOrderRandomNumbers()
    {
        for ($i = 0; $i < 11; $i++) {
            $numbers[] = rand(0, 99);
        }

        $sorted = array_sort_numbers($numbers);

        // $alternative = array_sort_numbers_alternative($numbers);

        // $this->assertEquals($sorted, $alternative);

        // Native sort numbers
        sort($numbers);

        // Assert is the same
        $this->assertEquals($sorted, $numbers);

        for ($i = 0; $i < 11; $i++) {
            $numbers[] = rand(0, 99);
        }

        $times = 1000; // 10k

        $timelapse = -hrtime(true);

        for ($i = 0; $i < $times; $i++) {
            array_sort_numbers($numbers);
        }

        $timelapse += hrtime(true);

        $microseconds = $timelapse / 1e+6; // microseconds

        echo PHP_EOL . "Run {$times} times in {$microseconds} microseconds";

        $biMicroseconds = 1e+10 * $microseconds;

        $seconds = $biMicroseconds / 1e+6;
        $hours = $seconds / 60 / 60;

        echo PHP_EOL . "It would take {$hours} hours to run 1 billion times";

        $days = $hours / 24;

        echo PHP_EOL . "It would take {$days} days to run 1 billion times";
    }
}


