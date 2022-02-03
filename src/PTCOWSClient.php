<?php

namespace Infocamere\EGov;

/**
* Webservice PTCOWS per dati informativi Certificati di origine 
*/
class PTCOWSClient
{
    private $url = 'https://praticaegovws.infocamere.it:52443/ptcows/';
    private $data = [
        'user' => null,
        'passwd' => null,
        'utenteOperativo' => null,
        'cciaa' => null,
    ];

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        \Unirest\Request::defaultHeaders([
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json'
        ]);

        $this->data['user']   = $username;
        $this->data['passwd'] = $password;
    }

    /**
     * Permette di verificare la disponibiltà del servizio informativo. Non richiede autenticazione
     * 
     * @return array
     */
    public function getStatus()
    {
        $request = \Unirest\Request::get($this->url.'getStatus');
        return $request->body;
    }

    /**
     * Permette di ottenere l'informazione se l'ente camerale ha abilitato o meno il pagamento differito (ovvero in contanti allo sportello)
     * 
     * @param string $cciaa
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function checkPagamentoDifferito($cciaa, $utenteOperativo = null) 
    {
        $this->data['cciaa'] = strtoupper($cciaa);

        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }
        
        $request = \Unirest\Request::post($this->url.'checkPagamentoDifferito', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di ottenere l'informazione se per la pratica indicata è stata richiesta la rettifica sul modello base o su un allegato
     * 
     * @param string $cciaa
     * @param string $codPratica
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function checkRettificaModelloBase($cciaa, $codPratica, $utenteOperativo = null)
    {
        $this->data['cciaa'] = strtoupper($cciaa);
        $this->data['codPratica'] = $codPratica;

        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }
        
        $request = \Unirest\Request::post($this->url.'checkRettificaModelloBase', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di verificare se l'azienda speditrice è abilitata alla stampa in azienda dei Certificati/Visti
     * 
     * @param string $cciaa
     * @param string $cf
     * 
     * @return array
     */
    public function checkStampaAzienda($cciaa, $cf)
    {
        $this->data['cciaa'] = strtoupper($cciaa);
        $this->data['codFiscale'] = $cf;
        
        $request = \Unirest\Request::post($this->url.'checkStampaAzienda', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di ottenere l'indicazione se per l'ente camerale indicato è disponibile la modalità di richiesta con urgenza
     * 
     * @param string $cciaa
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function checkUrgenze($cciaa, $utenteOperativo = null) 
    {
        $this->data['cciaa'] = strtoupper($cciaa);

        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }
        
        $request = \Unirest\Request::post($this->url.'checkUrgenze', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di ottenere l'informazione di quante pratiche urgenti sono disponibili al massimo in un anno, per un dato ente camerale,
     * per l'azienda indicata dal codice fiscale associato al codice pratica
     * 
     * @param string $cciaa
     * @param string $cf
     * @param string $codPratica
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function getNumeroMaxPraticheUrgentiAnno($cciaa, $cf, $codPratica, $utenteOperativo = null)
    {   
        $this->data['cciaa'] = strtoupper($cciaa);
        $this->data['codPratica'] = $codPratica;
        $this->data['codFiscale'] = $cf;

        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }
        
        $request = \Unirest\Request::post($this->url.'getNumeroMaxPraticheUrgentiAnno', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di ottenere l'informazione di quante pratiche urgenti sono già state inviate nell'anno in corso, sul dato ente camerale,
     * dall'azienda indicata dal codice fiscale associato al codice pratica
     * 
     * @param string $cciaa
     * @param string $cf
     * @param string $codPratica
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function getNumeroPraticheInviateUrgentiAnno($cciaa, $cf, $codPratica, $utenteOperativo = null)
    {   
        $this->data['cciaa'] = strtoupper($cciaa);
        $this->data['codPratica'] = $codPratica;
        $this->data['codFiscale'] = $cf;

        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }
        
        $request = \Unirest\Request::post($this->url.'getNumeroPraticheInviateUrgentiAnno', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di ottenere l'informazione se per l'ente camerale indicato è disponibile la modalità di stampa in azienda sul formulario ministeriale
     * 
     * @param string $cciaa
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function checkSupportoFormulario($cciaa, $utenteOperativo = null)
    {
        $this->data['cciaa'] = strtoupper($cciaa);
        
        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }

        $request = \Unirest\Request::post($this->url.'checkSupportoFormulario', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }

    /**
     * Permette di ottenere l'informazione se per l'ente camerale indicato è disponibile la modalità di stampa in azienda su foglio bianco
     * 
     * @param string $cciaa
     * @param string $utenteOperativo
     * 
     * @return array
     */
    public function checkSupportoFoglioBianco($cciaa, $codFiscale, $utenteOperativo = null)
    {
        $this->data['cciaa'] = strtoupper($cciaa);
        $this->data['codFiscale'] = $codFiscale;
        
        if (!is_null($utenteOperativo)) {
            $this->data['utenteOperativo'] = $utenteOperativo;
        }
        $request = \Unirest\Request::post($this->url.'checkSupportoFoglioBianco', [], \Unirest\Request\Body::json($this->data));
        return $request->body;
    }
}