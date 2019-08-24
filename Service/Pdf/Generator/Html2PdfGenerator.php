<?php

namespace Atournayre\ToolboxBundle\Service\Pdf\Generator;

use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class Html2PdfGenerator implements PdfGeneratorInterface
{
    /**
     * @var string
     */
    private $orientation;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $unicode;

    /**
     * @var string
     */
    private $encoding;

    /**
     * @var array
     */
    private $margins;

    /**
     * Html2PdfGenerator constructor.
     *
     * @param string $orientation
     * @param string $format
     * @param string $language
     * @param string $unicode
     * @param string $encoding
     * @param array $margins
     */
    public function __construct(
        string $orientation,
        string $format,
        string $language,
        string $unicode,
        string $encoding,
        array $margins
    ) {
        $this->orientation = $orientation;
        $this->format = $format;
        $this->language = $language;
        $this->unicode = $unicode;
        $this->encoding = $encoding;
        $this->margins = $margins;
    }

    /**
     * @return mixed|Html2Pdf
     */
    public function create() {
        return new Html2Pdf(
            $this->orientation,
            $this->format,
            $this->language,
            $this->unicode,
            $this->encoding,
            $this->margins
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
