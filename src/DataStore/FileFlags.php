<?php

namespace OpenConext\Component\EngineBlockFixtures\DataStore;

class FileFlags
{
    protected $dir;

    public function __construct($dir, $rootDir = '')
    {
//        $dir = $this->makeAbsolutePath($dir, $rootDir);
        $this->setDir($dir);
    }

    protected function makeAbsolutePath($filePath, $rootDir)
    {
        if ($filePath[0] === DIRECTORY_SEPARATOR) {
            return $filePath;
        }

        return $rootDir . DIRECTORY_SEPARATOR . $filePath;
    }

    protected function setDir($dir)
    {
        if (is_writeable($dir)) {
            $this->dir = $dir;
            return;
        }

        if (!file_exists($this->dir)) {
            $madeDir = mkdir($this->dir, 0755, true);
            if (!$madeDir) {
                throw new \RuntimeException('Unable to create directory: ' . $this->dir);
            }
        }

        $this->dir = $dir;
    }

    public function on($name, $value)
    {
        file_put_contents($this->dir . DIRECTORY_SEPARATOR . $name, $value);
    }

    public function off($name)
    {
        $file = $this->dir . DIRECTORY_SEPARATOR . $name;
        if (!file_exists($file)) {
            return;
        }

        unlink($file);
    }
}
