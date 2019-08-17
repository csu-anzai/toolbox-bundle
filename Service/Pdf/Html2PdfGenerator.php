<?php

namespace Atournayre\ToolboxBundle\Service\Pdf;

use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class Html2PdfGenerator implements PdfGeneratorInterface
{
    /**
     * @param string $orientation
     * @param string $format
     * @param string $language
     * @param bool   $unicode
     * @param string $encoding
     * @param array  $margins
     *
     * @return Html2Pdf
     */
    public function create(
        string $orientation = self::DEFAULT_ORIENTATION,
        string $format = self::DEFAULT_FORMAT,
        string $language = self::DEFAULT_LANGUAGE,
        bool $unicode = self::DEFAULT_UNICODE,
        string $encoding = self::DEFAULT_ENCODING,
        array $margins = self::DEFAULT_MARGINS
    ) {
        return new Html2Pdf(
            $orientation,
            $format,
            $language,
            $unicode,
            $encoding,
            $margins
        );
    }

    /**
     * @param Html2Pdf $pdf
     * @param string   $template
     * @param string   $name
     * @param string   $outputType
     *
     * @return string
     * @throws Html2PdfException
     */
    public function output($pdf, string $template, string $name, string $outputType = self::DEFAULT_OUTPUT): string
    {
        $pdf->writeHTML($template);
        return $pdf->output($name . self::EXTENSION, $outputType);
    }

    /**
     * @param Html2Pdf $pdf
     * @param string   $template
     * @param string   $name
     *
     * @return string
     * @throws Html2PdfException
     */
    public function save($pdf, string $template, string $name): string
    {
        $pdf->writeHTML($template);
        $filePath = $name . self::EXTENSION;
        $pdf->output($filePath, self::OUTPUT_SAVE);
        return $filePath;
    }
}
