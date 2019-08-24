<?php

namespace Atournayre\ToolboxBundle\Service\Pdf\Merger;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Tomsgu\PdfMerger\Exception\FileNotFoundException;
use Tomsgu\PdfMerger\Exception\InvalidArgumentException;
use Tomsgu\PdfMerger\PdfCollection;
use Tomsgu\PdfMerger\PdfMerger as TomsguPdfMerger;

class PdfMerger implements PdfMergerInterface
{
    const BROWSER  = 'I';
    const DOWNLOAD = 'D';
    const FILE     = 'F';
    const STRING   = 'S';

    const LANDSCAPE = 'landscape';
    const PORTRAIT  = 'portrait';

    const ALL_PAGES = 'all';

    /**
     * @var PdfCollection
     */
    private $collection;

    /**
     * @var TomsguPdfMerger
     */
    private $pdfMerger;

    /**
     * PdfFusionService constructor.
     */
    public function __construct()
    {
        $this->pdfMerger = new TomsguPdfMerger(new Fpdi());
        $this->collection = new PdfCollection();
    }

    /**
     * @param string $filePath
     * @param string $pages
     * @param string $orientation
     *
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     */
    public function addDocument(
        string $filePath,
        string $pages = self::ALL_PAGES,
        string $orientation = self::PORTRAIT
    ): void {
        $this->collection->addPdf($filePath, $pages, $orientation);
    }

    /**
     * @param array $filePaths
     *
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     */
    public function addDocuments(array $filePaths): void
    {
        foreach ($filePaths as $filePath) {
            $this->collection->addPdf($filePath);
        }
    }

    /**
     * @param string $filePath
     * @param string $mode
     * @param string $orientation
     *
     * @return string
     * @throws InvalidArgumentException
     * @throws PdfReaderException
     */
    public function merge(
        string $filePath,
        string $mode = self::FILE,
        string $orientation = self::PORTRAIT
    ): string {
        return $this->pdfMerger->merge($this->collection, $filePath, $mode, $orientation);
    }
}
