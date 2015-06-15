<?php

use Paperwork\App\Commands\AbstractPaperworkCommand;

class AbstractPaperworkCommandTest extends TestCase
{
    public function testResolve() {
        if(AbstractPaperworkCommand::isWindows()) {
            $this->assertFalse(AbstractPaperworkCommand::resolveExecutable('fadfadsfsa'));
            $this->assertEquals('C:\\Windows\\explorer.exe', AbstractPaperworkCommand::resolveExecutable('explorer'));
        } else {
            $this->assertFalse(AbstractPaperworkCommand::resolveExecutable('fadfadsfsa'));
            $this->assertEquals('/bin/bash', AbstractPaperworkCommand::resolveExecutable('bash'));
        }

    }
}