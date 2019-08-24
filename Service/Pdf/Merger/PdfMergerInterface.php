<?php

namespace Atournayre\ToolboxBundle\Service\Pdf\Merger;

interface PdfMergerInterface
{
    /**
     * @param string $filePath
     * @param string $pages
     * @param string $orientation
     */
    public function addDocument(string $filePath, string $pages, string $orientation): void;

    /**
     * @param array $filesPaths
     */
    public function addDocuments(array $filesPaths): void;

    /**
     * @param string $filePath
     * @param string $mode
     * @param string $orientation
     *
     * @return string
     */
    public function merge(string $filePath, string $mode, string $orientation): string;
}
