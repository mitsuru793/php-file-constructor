<?php
declare(strict_types=1);

namespace Mitsuru793\FileConstructor;

final class FileConstructor
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    public static function inTempDir(): self
    {
        return new self(self::makeTmpDir());
    }

    public function root(): string
    {
        return $this->root;
    }

    public function append(array $structure, string $parent = '')
    {
        foreach ($structure as $entry => $value) {
            $path = empty($parent) ? $entry : ($parent . DIRECTORY_SEPARATOR . $entry);
            if (is_array($value)) {
                $this->makeDir($path);
                $this->append($value, $path);
            } else {
                $this->makeFile($path, $value);
            }
        }
    }

    private function makeDir(string $path): void
    {
        mkdir($this->root . DIRECTORY_SEPARATOR . $path);
    }

    private function makeFile(string $path, string $content = ''): void
    {
        $absPath = $this->root . DIRECTORY_SEPARATOR . $path;
        if (empty($content)) {
            touch($absPath);
        } else {
            file_put_contents($absPath, $content);
        }
    }

    private static function makeTmpDir(): string
    {
        $tmpName = tempnam(sys_get_temp_dir(), __FUNCTION__);
        @unlink($tmpName);
        @mkdir($tmpName);
        return $tmpName;
    }
}