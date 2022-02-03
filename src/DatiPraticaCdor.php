<?php

namespace Infocamere\EGov;

class DatiPraticaCdor
{
    private $desrizione;
    private $cciaaCompetenza;
    private $codiceSedeDistaccata;
    private $tipoPratica;
    private $tipoSportello;
    private $datiImpresa;

    public function __construct()
    {
        $this->desrizione = null;
        $this->cciaaCompetenza = null;
        $this->codiceSedeDistaccata = null;
        $this->tipoPratica = null;
        $this->tipoSportello = \Infocamere\EGov\Utils\TipoSportello::CO;
        $this->datiImpresa;
    }
    
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    public function setCciaaCompetenza($cciaaCompetenza)
    {
        $this->cciaaCompetenza = $cciaaCompetenza;
    }

    public function setCodiceSedeDistaccata($codiceSedeDistaccata)
    {
        $this->codiceSedeDistaccata = $codiceSedeDistaccata;
    }

    public function setTipoPratica($tipoPratica)
    {
        $this->tipoPratica = $tipoPratica;
    }

    public function setTipoSportello($tipoSportello)
    {
        $this->tipoSportello = $tipoSportello;
    }

    public function setDatiImpresa(DatiImpresa $datiImpresa)
    {
        $this->datiImpresa = $datiImpresa;
    }

    public function getDescrizione()
    {
        return $this->descrizione;
    }

    public function getCciaaCompetenza()
    {
        return $this->cciaaCompetenza;
    }

    public function getCodiceSedeDistaccata()
    {
        return $this->codiceSedeDistaccata;
    }

    public function getTipoPratica()
    {
        return $this->tipoPratica;
    }

    public function getTipoSportello()
    {
        return $this->tipoSportello;
    }

    public function getDatiImpresa()
    {
        return $this->datiImpresa;
    }
}