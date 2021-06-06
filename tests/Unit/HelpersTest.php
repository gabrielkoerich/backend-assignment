<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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

        dump("Deleted $deleted files");
    }
}
