<?php

namespace Infocamere\EGov;

class DatiPraticaBase
{
    private $tipoSportello;
    private $cciaaCompetenza;
    private $tipoPratica;
    private $descrizione;
    private $datiImpresa;
    private $datiIdp;
    private $codiceSedeDistaccata;

    public function __construct()
    {
        $this->tipoSportello = null;
        $this->cciaaCompetenza = null;
        $this->tipoPratica = null;
        $this->descrizione = null;
        $this->datiIdp = null;
        $this->codiceSedeDistaccata = null;
    }

    public function setTipoSportello($tipoSportello)
    {
        $this->tipoSportello = $tipoSportello;
    }

    public function getTipoSportello()
    {
        return $this->tipoSportello;
    }

    public function setCciaaCompetenza($cciaaCompetenza)
    {
        $this->cciaaCompetenza = $cciaaCompetenza;
    }

    public function getCciaaCompetenza()
    {
        return $this->cciaaCompetenza;
    }

    public function setTipoPratica($tipoPratica)
    {
        $this->tipoPratica = $tipoPratica;
    }

    public function getTipoPratica()
    {
        return $this->tipoPratica;
    }
}