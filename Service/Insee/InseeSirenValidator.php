<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

use Exception;

class InseeSirenValidator extends InseeValidator
{
    /**
     * @param string $siren
     *
     * @return bool
     * @throws Exception
     */
    public function validate(string $siren): bool
    {
        $this->checkNotEmpty($siren, 'SIREN');
        $informations = $this->inseeSirene->get(InseeSirene::URL_API_SIREN, $siren, $this->inseeToken->get());
        $currentInformations = $this->getCurrentInformations($informations);
        return $this->checkValidity($currentInformations);
    }

    /**
     * @param object $datasFromApi
     *
     * @return object
     * @throws Exception
     */
    public function getCurrentInformations(object $datasFromApi): object
    {
        $this->checkApiResponse($datasFromApi);
        $periodesUniteLegale = $datasFromApi->uniteLegale->periodesUniteLegale;
        $this->checkNoDatas($periodesUniteLegale);
        return $periodesUniteLegale[0];
    }

    /**
     * @param object $currentInformations
     *
     * @return bool
     */
    public function checkValidity(object $currentInformations): bool
    {
        return self::COMPANY_IN_ACTIVITY === $currentInformations->etatAdministratifUniteLegale
               && $this->hasNoEndDate($currentInformations);
    }
}
