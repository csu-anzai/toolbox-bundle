<?php

namespace Atournayre\ToolboxBundle\Service\File;

use Symfony\Component\HttpFoundation\File\File;

class FileService
{
    /**
     * @var string
     */
    private $salt;

    /**
     * FileService constructor.
     *
     * @param string $salt
     */
    public function __construct(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param File $file
     *
     * @return string
     */
    public function setFileName(File $file): string
    {
        return sprintf('%s.%s', $this->setUniqueFileName($file), $file->getExtension());
    }

    /**
     * @param File $file
     *
     * @return string
     */
    public function setUniqueFileName(File $file): string
    {
        return crypt($file->getFilename(), $this->salt);
    }

    /**
     * @param File   $file
     * @param string $folder
     *
     * @return File
     */
    public function saveFileToDisk(File $file, string $folder): File
    {
        return $file->move($folder, $this->setFileName($file));
    }
}
