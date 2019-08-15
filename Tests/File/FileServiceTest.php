<?php

namespace Atournayre\ToolboxBundle\Tests\File;

use Atournayre\ToolboxBundle\Service\File\FileService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class FileServiceTest extends TestCase
{
    public function testFileNameWithExtension()
    {
        $file = new File(__DIR__.'/../datas/blank.pdf', 'blank.pdf');
        $fileService = new FileService('');
        $this->assertStringEndsWith('.pdf', $fileService->setFileName($file));
    }

    public function testUniqueFileName()
    {
        $salt = 'lqs5xs32n2f45g52l52m25e25s245j4s5q32545g';
        $file = new File(__DIR__.'/../datas/blank.pdf', 'blank.pdf');
        $fileService = new FileService($salt);
        $fileName = crypt($file->getBasename(), $salt);
        $this->assertEquals($fileName, $fileService->setUniqueFileName($file));
    }

    public function testUniqueFileNameWithExtension()
    {
        $salt = 'lqs5xs32n2f45g52l52m25e25s245j4s5q32545g';
        $file = new File(__DIR__.'/../datas/blank.pdf', 'blank.pdf');
        $fileService = new FileService($salt);
        $fileName = crypt($file->getBasename(), $salt).'.pdf';
        $this->assertEquals($fileName, $fileService->setFileName($file));
    }

    public function testSaveFileToDisk()
    {
        $tmpPdf = __DIR__ . '/../datas/tmp.pdf';
        (new Filesystem())->touch($tmpPdf);
        $fileService = new FileService('lqs5xs32n2f45g52l52m25e25s245j4s5q32545g');
        $this->assertFileExists($fileService->saveFileToDisk(new File($tmpPdf), realpath(__DIR__.'/../tmp')));
    }
}
