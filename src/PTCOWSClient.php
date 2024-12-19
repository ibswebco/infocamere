<?php

namespace Infocamere\EGov;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;

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

    private $client = null;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->client = new Client([
            'base_uri' => $this->url,
            'timeout'  => 30.0,
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
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
        $response = $this->client->get('getStatus');
        
        return $this->jsonBody($response->getBody());
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
        
        $response = $this->client->post('checkPagamentoDifferito', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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
  
        $response = $this->client->post('checkRettificaModelloBase', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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

        $response = $this->client->post('checkStampaAzienda', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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

        $response = $this->client->post('checkUrgenze', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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

        $response = $this->client->post('getNumeroMaxPraticheUrgentiAnno', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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

        $response = $this->client->post('getNumeroPraticheInviateUrgentiAnno', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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

        $response = $this->client->post('checkSupportoFormulario', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
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
        
        $response = $this->client->post('checkSupportoFoglioBianco', [
            'json' => $this->data
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    private function sendRequest(string $method, string $uri, array $body)
    {
        try {
            $response = $this->client->request(strtoupper($method), $uri, [
                'json' => $body
            ]);
            
            return $this->jsonBody($response->getBody());
        } catch (ClientException $e) {
            return $e->getResponse(); //getMessage()
        } catch (ServerException $e) {
            return $e->getResponse();
        } catch (RequestException $e) {
            return $e->getResponse();
        }
    }

    private function jsonBody($body)
    {        
        if (!is_null($body)) {
            return json_decode($body->getContents());
        }

        return null;
    }
}