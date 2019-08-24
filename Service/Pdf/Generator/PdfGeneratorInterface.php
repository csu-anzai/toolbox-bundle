<?php

namespace Atournayre\ToolboxBundle\Service\Pdf\Generator;

interface PdfGeneratorInterface
{
    const EXTENSION = '.pdf';

    /**
     *  I : send the file inline to the browser (default). The plug-in is used if available. The name given by name is
     *  used when one selects the "Save as" option on the link generating the PDF. D : send to the browser and force a
     *  file download with the name given by name. F : save to a local server file with the name given by name. S :
     *  return the document as a string (name is ignored). FI: equivalent to F + I option FD: equivalent to F + D
     *  option E : return the document as base64 mime multi-part email attachment (RFC 2045)
     */
    const DEFAULT_OUTPUT = self::OUTPUT_INLINE;

    const OUTPUT_INLINE            = 'I';
    const OUTPUT_DOWNLOAD          = 'D';
    const OUTPUT_SAVE              = 'F';
    const OUTPUT_STRING            = 'S';
    const OUTPUT_SAVE_AND_INLINE   = 'FI';
    const OUTPUT_SAVE_AND_DOWNLOAD = 'FD';
    const OUTPUT_FOR_EMAIL         = 'E';

    /**
     * @return mixed
     */
    public function create();

    /**
     * @param mixed  $pdf
     * @param string $template
     * @param string $name
     * @param string $outputType
     *
     * @return string
     */
    public function output($pdf, string $template, string $name, string $outputType = self::DEFAULT_OUTPUT): string;

    /**
     * @param mixed  $pdf
     * @param string $template
     * @param string $name
     *
     * @return string
     */
    public function save($pdf, string $template, string $name): string;
}
