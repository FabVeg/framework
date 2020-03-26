<?php

namespace Test;
use PHPUnit\Framework\TestCase;

class DirectoryExistsTest extends TestCase
{
    public function testFailure()
    {
        $this->assertDirectoryExists(ROOT_DIR."/app");
    }
}


class FileExistsTest extends TestCase
{
    public function testFailure()
    {
        $this->assertFileExists(ROOT_DIR."/README.md");
    }
}

class FileIsReadableTest extends TestCase
{
    public function testFailure()
    {
        $this->assertFileIsReadable(ROOT_DIR."/README.md");
    }
}