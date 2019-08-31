<?php

namespace Atournayre\ToolboxBundle\Installer;

use Symfony\Component\Finder\SplFileInfo;

class Address
{
    const DATA_FOLDER = '/Datas/Address';

    /**
     * @return array
     */
    public function files(): array
    {
        return [
            'countries.sql',
            'fr_FR_cities.sql',
        ];
    }

    /**
     * @return string
     */
    public function prepareSql(): string
    {
        $sql = '';
        foreach ($this->files() as $file) {
            $sql .= $this->getFileContents($file);
        }
        return $sql;
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public function getFileContents(string $file): string
    {
        $fileRoot = '..' . self::DATA_FOLDER . DIRECTORY_SEPARATOR;
        $splFileInfo = new SplFileInfo($fileRoot . $file, '', '');
        return $splFileInfo->getContents();

    }
}
