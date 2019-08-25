<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

use Exception;

class InseeValidator
{
    const COMPANY_IN_ACTIVITY = 'A';

    /**
     * @var InseeToken
     */
    protected $inseeToken;

    /**
     * @var InseeSirene
     */
    protected $inseeSirene;

    /**
     * InseeValidator constructor.
     *
     * @param InseeToken  $inseeToken
     * @param InseeSirene $inseeSirene
     */
    public function __construct(InseeToken $inseeToken, InseeSirene $inseeSirene)
    {
        $this->inseeToken = $inseeToken;
        $this->inseeSirene = $inseeSirene;
    }

    /**
     * @param object $currentInformations
     *
     * @return bool
     */
    public function hasNoEndDate(object $currentInformations): bool
    {
        return null === $currentInformations->dateFin;
    }

    /**
     * @param object $datasFromApi
     *
     * @throws Exception
     */
    public function checkApiResponse(object $datasFromApi): void
    {
        if (200 !== $datasFromApi->header->statut) {
            throw new Exception($datasFromApi->header->message);
        }
    }

    /**
     * @param array $datas
     *
     * @throws Exception
     */
    public function checkNoDatas(array $datas): void
    {
        if (!array_key_exists(0, $datas)) {
            throw new Exception('No datas for this company.');
        }
    }
}
