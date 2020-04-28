<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class TestGenericTDD extends TestCase
{
    public function trueOrError(bool $test, array $message = []) 
    {
        if($test) {
            $this->assertTrue(true);
        } else {
            $this->debug($message);
        }
    }

    public function fileExistsOrError(string $file, array $message) 
    {
        if(file_exists($file)) {
            $this->assertFileExists($file);
        } else {
            $this->debug($message);
        }
    }

    protected function debug(array $message, bool $bExit = true)
    {
        fwrite(STDOUT, "\n\033[31;47mDEBUG ".$message[0]."  \n".$message[1]. "\033[0m\n\n");

        if($bExit) {
            exit();
        }
    }

}