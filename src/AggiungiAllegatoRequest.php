<?php

namespace Infocamere\EGov;

class AggiungiAllegatoRequest
{
    private $allegatoFileName;
    private $descrizioneAllegato;
    private $modelloBase;
    private $tipoAllegato;
    private $codiceAllegato = [
        "bolletta doganale" => "bol",
        "dichiarazione di origine" => "ddo",
        "documento di trasporto" => "dot",
        "fattura di acquisto" => "faa",
        "fattura di esportazione" => "fae",
        "altro" => "gen",
        "listino prezzi" => "lip",
        "certificato di origine estero"  => "coe",
        "packing list" => "pac",
        "modello base" => "mob",
        "attestato di libera vendita" => "alv",
        "autorizzazione" => "aut",
        "certificato" => "cer",
        "fattura" => "fat",
        "visto di deposito" => "vde",
        "visto poteri di firma" => "vpt"
    ];

    private $rettificaModelloBase;

    public function __construct()
    {
        $this->allegatoFileName = null;
        $this->descrizioneAllegato = null;
        $this->modelloBase = null;
        $this->tipoAllegato = null;
        $this->rettificaModelloBase = false;
    }

    public function setDescrizioneAllegato($descrizioneAllegato)
    {
        $this->descrizioneAllegato = $descrizioneAllegato;
    }

    public function getDescrizioneAllegato()
    {
        return $this->descrizioneAllegato;
    }

    public function setAllegatoFileName($allegatoFileName)
    {
        $this->allegatoFileName = $allegatoFileName;
    }

    public function getAllegatoFileName()
    {
        return $this->allegatoFileName;
    }

    public function setModelloBase($mob)
    {
        $this->modelloBase = base64_encode($mob);
    }

    public function getModelloBase()
    {
        return $this->modelloBase;
    }

    public function setTipoAllegato($tipoAllegato)
    {
        if (empty($tipoAllegato)) {
            $tipo = 'gen';
        }
        else {
            $tipo = strlen($tipoAllegato) == 3 ? $tipoAllegato : $this->codiceAllegato[strtolower($tipoAllegato)];
        }
        
        $this->tipoAllegato = strtoupper($tipo);
    }

    public function getTipoAllegato()
    {
        return $this->tipoAllegato;
    }

    public function setRettificaModelloBase($isRettificaModelloBase)
    {
        $this->rettificaModelloBase = $isRettificaModelloBase;
    }

    public function isRettificaModelloBase()
    {
        return $this->rettificaModelloBase;
    }
}