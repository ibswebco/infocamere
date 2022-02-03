<?php

namespace Infocamere\EGov;

class ListaPraticheRequest
{
    private $datiPratica;
    private $aperte;
    private $filtri;

    public function __construct()
    {
        $this->datiPratica = null;
        $this->aperte = false;
        $this->filtri = [];
    }

    public function setDatiPratica(DatiPraticaBase $datiPratica)
    {
        $this->datiPratica = $datiPratica;
    }

    public function getDatiPratica()
    {
        return $this->datiPratica;
    }

    public function setAperte($aperte)
    {
        $this->aperte = $aperte;
    }

    public function getAperte()
    {
        return $this->aperte;
    }

    public function addFiltri($k, $v)
    {
        $this->filtri[$k] = $v;
    }

    public function getFiltri()
    {
        return $this->filtri;
    }
}