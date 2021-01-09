<?php
declare(strict_types=1);

namespace UnitTest;

use Mitsuru793\FileConstructor\FileConstructor;
use TestHelper\TestCase;

class FileConstructorTest extends TestCase
{
    public function testInTempDir()
    {
        $fc = FileConstructor::inTempDir();
        $this->assertDirectoryExists($fc->root());
    }

    public function testMake()
    {
        $root = $this->makeTmpDir();
        $fs = new FileConstructor($root);
        $fs->append([
            'dir1' => [],
            'dir2' => [
                'dir3' => [],
                'dir2-f1' => '',
            ],
            'f1' => '',
            'f2' => 'hello',
        ]);

        $this->assertDirectoryExists("$root/dir1");
        $this->assertDirectoryExists("$root/dir2");
        $this->assertDirectoryExists("$root/dir2/dir3");
        $this->assertFileExists("$root/dir2/dir2-f1");

        $this->assertFileExists("$root/f1");
        $this->assertStringEqualsFile("$root/f1", '');
        $this->assertFileExists("$root/f2");
        $this->assertStringEqualsFile("$root/f2", 'hello');
    }

    private function makeTmpDir(): string
    {
        $tmpName = tempnam(sys_get_temp_dir(), __FUNCTION__);
        @unlink($tmpName);
        @mkdir($tmpName);
        return $tmpName;
    }
}
