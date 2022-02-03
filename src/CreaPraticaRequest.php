<?php

namespace Infocamere\EGov;

class CreaPraticaRequest
{
    private $modelloBase;
    private $datiPratica;
    
    public function setModelloBase($mob)
    {
        $this->modelloBase = base64_encode($mob);
    }

    public function setDatiPratica(DatiPraticaCdor $datiPratica)
    {
        $this->datiPratica = $datiPratica;
    }

    public function getModelloBase()
    {
        return $this->modelloBase;
    }

    public function getDatiPratica()
    {
        return $this->datiPratica;
    }
}