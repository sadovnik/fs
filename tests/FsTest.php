<?php

namespace Fs\Tests;

use PHPUnit\Framework\TestCase;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamDirectory;

use Fs\Fs;
use Fs\Exceptions\IoException;
use Fs\Exceptions\PermissionDeniedException;

class FsTest extends TestCase
{
    protected $root;

    public function setUp()
    {
        $this->root = vfsStream::setUp();
    }

    public function testReadNormal()
    {
        $file = (new vfsStreamFile('some.file'))->withContent('content');
        $this->root->addChild($file);
        $result = Fs::read($file->url());
    }

    public function testReadNotFoundError()
    {
        try {
            $result = Fs::read($this->root->url() . '/non-existing.file');
            $this->fail();
        } catch (IoException $e) {
            $this->assertContains('File not found', $e->getMessage());
        }
    }

    public function testReadNotAFile()
    {
        try {
            $result = Fs::read($this->root->url());
            $this->fail();
        } catch (IoException $e) {
            $this->assertContains('is not a file', $e->getMessage());
        }
    }

    public function testReadPermissionDeniedError()
    {
        $file = new vfsStreamFile('some.file', 0000);
        $this->root->addChild($file);

        try {
            $result = Fs::read($file->url());
            $this->fail();
        } catch (IoException $e) {
            $this->assertContains('Permission denied', $e->getMessage());
        }
    }

    public function testIsDirNormal()
    {
        $directory = new vfsStreamDirectory('project');
        $file = new vfsStreamFile('some.file');
        $this->root->addChild($directory);
        $this->root->addChild($file);
        $this->assertTrue(Fs::isDir($directory->url()));
        $this->assertFalse(Fs::isDir($file->url()));
    }

    public function testIsDirPermissionDenied()
    {
        $rootDirectory = new vfsStreamDirectory('project');
        $this->root->addChild($rootDirectory);
        $childDirectory = new vfsStreamDirectory('src', 0000);
        $rootDirectory->addChild($childDirectory);

        try {
            $result = Fs::isDir($childDirectory->url());
            $this->fail();
        } catch (IoException $e) {
            $this->assertContains('Permission denied', $e->getMessage());
        }
    }

    public function testIsDirNotFound()
    {
        $directory = new vfsStreamDirectory('project');
        $this->root->addChild($directory);

        try {
            $result = Fs::isDir($directory->url() . '/non-existing-directory/');
            $this->fail();
        } catch (IoException $e) {
            $this->assertContains('File or directory not found:', $e->getMessage());
        }
    }
}
