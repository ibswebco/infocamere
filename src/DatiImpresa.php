<?php

namespace Infocamere\EGov;

class DatiImpresa
{
    private $nrea;
    private $cciaa;
    private $codFisc;
    private $indirizzo;
    private $cap;
    private $comune;
    private $provincia;
    private $denominazione;

    public function __construct()
    {
        $this->nrea = null;
        $this->cciaa = null;
        $this->codFisc = null;
        $this->indirizzo = null;
        $this->cap = null;
        $this->comune = null;
        $this->provincia = null;
        $this->denominazione = null;
    }

    public function setNrea($nrea)
    {
        $this->nrea = $nrea;
    }

    public function setCodFisc($cf)
    {
        $this->codFisc = $cf;
    }

    public function setCciaa($cciaa)
    {
        $this->cciaa = $cciaa;
    }

    public function setIndirizzo($indirizzo)
    {
        $this->indirizzo = $indirizzo;
    }

    public function setCap($cap)
    {
        $this->cap = $cap;
    }

    public function setComune($comune)
    {
        $this->comune = $comune;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    public function setDenominazione($denominazione)
    {
        $this->denominazione = $denominazione;
    }

    public function getNrea()
    {
        return $this->nrea;
    }

    public function getCodFisc()
    {
        return $this->codFisc;
    }

    public function getCciaa()
    {
        return $this->cciaa;
    }

    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    public function getCap()
    {
        return $this->cap;
    }

    public function getComune()
    {
        return $this->comune;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function getDenominazione()
    {
        return $this->denominazione;
    }
}