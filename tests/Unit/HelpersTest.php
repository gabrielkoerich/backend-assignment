<?php

namespace Tests\Unit;

use Throwable;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Test helpers defined on app\helpers.php
 */
class HelpersTest extends TestCase
{
    /**
     * Test find files begining with "0aH" and delete them
     */
    public function testDeleteFilesMatching()
    {
        $files = rand(500, 9999);

        $path = getcwd() . '/tests/Unit/stubs';

        $directories = ['a', 'b', 'c'];

        @mkdir($path);
        foreach ($directories as $directory) {
            @mkdir($path . '/' . $directory);
        }

        $extensions = ['', '.txt', '.php', '.md'];

        for ($i = 0; $i < $files; $i++) {
            touch("{$path}/{$directories[array_rand($directories)]}/0aH$i{$extensions[array_rand($extensions)]}");
        }

        $deleted = delete_files_matching($path, '0aH*');

        $this->assertEquals($files, $deleted);
    }

    /**
     * Test function to sort random small numbers
     */
    public function testOrderRandomSmallNumbers()
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

        $times = 1000;
        $timelapse = -hrtime(true);

        for ($i = 0; $i < $times; $i++) {
            // regenerate numbers each time?
            // $numbers = [];

            // for ($n = 0; $n < 11; $n++) {
            //     $numbers[] = rand(0, 99);
            // }

            array_sort_numbers($numbers);
        }

        $timelapse += hrtime(true);

        $microseconds = $timelapse / 1e+6; // microseconds

        echo PHP_EOL . "Run {$times} times in {$microseconds} microseconds";

        $biMicroseconds = (1e+10 * $microseconds) / $times * 1000;

        $seconds = $biMicroseconds / 1e+6;
        $hours = $seconds / 60 / 60;

        echo PHP_EOL . "It would take {$hours} hours to run 10 billion times";

        $days = $hours / 24;

        echo PHP_EOL . "It would take {$days} days to run 10 billion times";
    }

    public function testOrderRandomBigNumbers()
    {
        $this->markTestSkipped('too slow to run on CI');

        $times = 1;
        $timelapse = -hrtime(true);

        // Generate small numbers, ordem them and later use pow()
        for ($i = 0; $i < 10000; $i++) {
            $a = rand(100, 10000);
            $b = rand(100, 10000);

            $as[] = $a;
            $bs[] = $b;

            $numbers[] = $a * $b;
        }

        for ($i = 0; $i < $times; $i++) {
            $sorted = array_sort_numbers($numbers, 'sortBy');
        }

        $powers = [];
        foreach ($sorted as $key => $value) {
            $powers[$key] = bcpow($as[array_search($value, $as)], $bs[array_search($value, $as)]);
        }

        $timelapse += hrtime(true);

        $microseconds = $timelapse / 1e+6; // microseconds

        echo PHP_EOL . "Run {$times} times in {$microseconds} microseconds";

        $biMicroseconds = 1e+10 * $microseconds / $times * 1000;

        $seconds = $biMicroseconds / 1e+6;
        $hours = $seconds / 60 / 60;

        echo PHP_EOL . "It would take {$hours} hours to run 1 billion times";

        $days = $hours / 24;

        echo PHP_EOL . "It would take {$days} days to run 1 billion times";
    }
}


