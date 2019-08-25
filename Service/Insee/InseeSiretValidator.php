<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

use Exception;

class InseeSiretValidator extends InseeValidator
{
    /**
     * @param string $siret
     *
     * @return bool
     * @throws Exception
     */
    public function validate(string $siret): bool
    {
        $informations = $this->inseeSirene->get(InseeSirene::URL_API_SIRET, $siret, $this->inseeToken->get());
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
        $periodesEtablissement = $datasFromApi->etablissement->periodesEtablissement;
        $this->checkNoDatas($periodesEtablissement);
        return $periodesEtablissement[0];
    }

    /**
     * @param object $currentInformations
     *
     * @return bool
     */
    public function checkValidity(object $currentInformations): bool
    {
        return self::COMPANY_IN_ACTIVITY === $currentInformations->etatAdministratifEtablissement
               && $this->hasNoEndDate($currentInformations);
    }

}
