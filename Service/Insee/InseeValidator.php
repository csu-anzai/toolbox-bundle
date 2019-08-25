<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

use Exception;

class InseeValidator
{
    /**
     * @var InseeToken
     */
    private $inseeToken;

    /**
     * @var InseeSirene
     */
    private $inseeSirene;

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
     * @param string $siren
     *
     * @return bool
     * @throws Exception
     */
    public function validateSiren(string $siren): bool
    {
        return $this->validate(InseeSirene::URL_API_SIREN, $siren);
    }

    /**
     * @param string $siret
     *
     * @return bool
     * @throws Exception
     */
    public function validateSiret(string $siret): bool
    {
        return $this->validate(InseeSirene::URL_API_SIRET, $siret);
    }

    /**
     * @param string $urlApi
     * @param string $sirene
     *
     * @return bool
     * @throws Exception
     */
    public function validate(string $urlApi, string $sirene): bool
    {
        $informations = $this->inseeSirene->get($urlApi, $sirene, $this->inseeToken->get());
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
        if (200 !== $datasFromApi->header->statut) {
            throw new Exception($datasFromApi->header->message);
        }

        $periodesEtablissement = $datasFromApi->etablissement->periodesEtablissement;

        if (!array_key_exists(0, $periodesEtablissement)) {
            throw new Exception('No datas for this company.');
        }
        return $periodesEtablissement[0];
    }

    /**
     * @param object $currentInformations
     *
     * @return bool
     */
    public function checkValidity(object $currentInformations): bool
    {
        return 'A' === $currentInformations->etatAdministratifEtablissement
               && null === $currentInformations->dateFin;
    }
}
