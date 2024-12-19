<?php

namespace Infocamere\EGov;

use GuzzleHttp\Client;

/**
 * Webservice FPWS per la comunicazione di pratiche telematiche EGov
 */
class FPWSClient
{
    private $url = "https://praticaegovws.infocamere.it:52443/fpbews/";
    
    private $dataMob = [
        'mobFirmato' => true,
        'modelloBaseB64' => null,
        'datiPratica' => [
            'tPratica' => 'cdor',
            'tipoSportello' => \Infocamere\EGov\Utils\TipoSportello::CO,
            'tipoPratica' => null,
            'descrizione' => null,
            'cciaaCompetenza' => null,
            'datiImpresa' => [
                'cciaa' => null,
                'nrea' => null,
                'codFisc' => null,
                'proloc' => null,
                'denominazione' => null,
                'indirizzo' => null,
                'comune' => null,
                'provincia' => null,
                'cap' => null
            ],
            'datiIdp' => null,
            'codiceSedeDistaccata' => null
        ],
    ];

    private $dataPrt = [
        'datiPratica' => [
            'tPratica' => 'cdor',
            'tipoSportello' => null,
            'tipoPratica' => null,
            'descrizione' => null,
            'cciaaCompetenza' => null,
            'datiImpresa' => null,
            'datiIdp' => null,
            'codiceSedeDistaccata' => null
        ],
        'aperte' => null,
        'filtri' => [
            'CODICE_PRATICA' => null,
            'CODICE_FISCALE' => null,
            'DATA_DOMANDA' => null,
            'SEDE_DISTACCATA' => null
        ]
    ];
    
    private $dataAll = [
        'modelloBaseB64' => null,
        'tipoAllegato' => null,
        'descrizioneAllegato' => null,
        'allegatoFileName' => null,
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
                'FPWS-UserId' => $username,
                'FPWS-Password' => $password,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
        ]);
    }

    /**
     * Creazione di una pratica con autenticazione diretta senza sessione
     * 
     * @param \Infocamere\EGov\CreaPraticaRequest $dataMob
     * @return array
     */
    public function creaPratica(CreaPraticaRequest $dataMob)
    {
        $this->dataMob['modelloBaseB64'] = $dataMob->getModelloBase();
        $this->dataMob['datiPratica']['descrizione'] = $dataMob->getDatiPratica()->getDescrizione();
        $this->dataMob['datiPratica']['tipoPratica'] = $dataMob->getDatiPratica()->getTipoPratica();
        $this->dataMob['datiPratica']['cciaaCompetenza'] = $dataMob->getDatiPratica()->getCciaaCompetenza();
        $this->dataMob['datiPratica']['codiceSedeDistaccata'] = $dataMob->getDatiPratica()->getCodiceSedeDistaccata();
        $this->dataMob['datiPratica']['datiImpresa']['cciaa'] = $dataMob->getDatiPratica()->getDatiImpresa()->getCciaa();
        $this->dataMob['datiPratica']['datiImpresa']['nrea'] = $dataMob->getDatiPratica()->getDatiImpresa()->getNrea();
        $this->dataMob['datiPratica']['datiImpresa']['codFisc'] = $dataMob->getDatiPratica()->getDatiImpresa()->getCodFisc();
        $this->dataMob['datiPratica']['datiImpresa']['denominazione'] = $dataMob->getDatiPratica()->getDatiImpresa()->getDenominazione();
        $this->dataMob['datiPratica']['datiImpresa']['provincia'] = $dataMob->getDatiPratica()->getDatiImpresa()->getProvincia();

        $response = $this->client->put('pratica/creaA2A', [
            'json' => $this->dataMob,
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function creaPraticaServiceUser(CreaPraticaRequest $dataMob, $userIdOperativo)
    {
        $this->dataMob['modelloBaseB64'] = $dataMob->getModelloBase();
        $this->dataMob['datiPratica']['descrizione'] = $dataMob->getDatiPratica()->getDescrizione();
        $this->dataMob['datiPratica']['tipoPratica'] = $dataMob->getDatiPratica()->getTipoPratica();
        $this->dataMob['datiPratica']['cciaaCompetenza'] = $dataMob->getDatiPratica()->getCciaaCompetenza();
        $this->dataMob['datiPratica']['codiceSedeDistaccata'] = $dataMob->getDatiPratica()->getCodiceSedeDistaccata();
        $this->dataMob['datiPratica']['datiImpresa']['cciaa'] = $dataMob->getDatiPratica()->getDatiImpresa()->getCciaa();
        $this->dataMob['datiPratica']['datiImpresa']['nrea'] = $dataMob->getDatiPratica()->getDatiImpresa()->getNrea();
        $this->dataMob['datiPratica']['datiImpresa']['codFisc'] = $dataMob->getDatiPratica()->getDatiImpresa()->getCodFisc();
        $this->dataMob['datiPratica']['datiImpresa']['denominazione'] = $dataMob->getDatiPratica()->getDatiImpresa()->getDenominazione();
        $this->dataMob['datiPratica']['datiImpresa']['provincia'] = $dataMob->getDatiPratica()->getDatiImpresa()->getProvincia();

        $response = $this->client->put('pratica/creaA2AServiceUser', [
            'query' => [
                'userIdOperativo' => $userIdOperativo
            ],
            'json' => $this->dataMob,
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Aggiunta allegato su pratica esistente con autenticazione diretta senza creazione di sessione
     * 
     * @param string $idPratica
     * @param \Infocamere\EGov\AggiungiAllegatoRequest $aggiungiAllegatoRequest
     * 
     * @return array
     */
    public function aggiungiAllegato($idPratica, AggiungiAllegatoRequest $aggiungiAllegatoRequest)
    {
        $this->dataAll['modelloBaseB64'] = $aggiungiAllegatoRequest->getModelloBase();
        $this->dataAll['allegatoFileName'] = $aggiungiAllegatoRequest->getAllegatoFileName();
        $this->dataAll['descrizioneAllegato'] = $aggiungiAllegatoRequest->getDescrizioneAllegato();
        $this->dataAll['tipoAllegato'] = $aggiungiAllegatoRequest->getTipoAllegato();

        $response = $this->client->put('pratica/aggiungiAllegatoA2A', [
            'query' => [
                'idPratica' => $idPratica,
            ],
            'json' => $this->dataAll,
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function aggiungiAllegatoServiceUser($idPratica, AggiungiAllegatoRequest $aggiungiAllegatoRequest, $userIdOperativo)
    {
        $this->dataAll['modelloBaseB64'] = $aggiungiAllegatoRequest->getModelloBase();
        $this->dataAll['allegatoFileName'] = $aggiungiAllegatoRequest->getAllegatoFileName();
        $this->dataAll['descrizioneAllegato'] = $aggiungiAllegatoRequest->getDescrizioneAllegato();
        $this->dataAll['tipoAllegato'] = $aggiungiAllegatoRequest->getTipoAllegato();
        
        $response = $this->client->put('pratica/aggiungiAllegatoA2AServiceUser', [
            'query' => [
                'idPratica' => $idPratica,
                'userIdOperativo' => $userIdOperativo,
            ],
            'json' => $this->dataAll,
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Invia pratica già creata con autenticazione diretta senza creazione di sessione
     * 
     * @param string $idPratica
     * 
     * @return array
     */
    public function inviaPratica($idPratica)
    {
        $response = $this->client->post('pratica/inviaA2A', [
            'query' => [
                'idPratica' => $idPratica,
            ],
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function inviaPraticaServiceUser($idPratica, $userIdOperativo)
    {
        $response = $this->client->post('pratica/inviaA2AServiceUser', [
            'query' => [
                'idPratica' => $idPratica,
                'userIdOperativo' => $userIdOperativo,
            ],
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Annulla pratica esistente con autenticazione diretta senza creazione di sessione
     * 
     * @param string $idPratica
     * 
     * @return array
     */
    public function annullaPratica($idPratica)
    {
        $response = $this->client->delete('pratica/annullaA2A', [
            'query' => [
                'idPratica' => $idPratica,
            ],
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function annullaPraticaServiceUser($idPratica, $userIdOperativo)
    {
        $response = $this->client->delete('pratica/annullaA2AServiceUser', [
            'query' => [
                'idPratica' => $idPratica,
                'userIdOperativo' => $userIdOperativo,
            ],
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Fornisce lista delle pratiche relative a un utente con relativi dati informativi. Permette la selezione in base a parametri impostati
     * 
     * @param \Infocamere\EGov\ListaPraticheRequest $listaPraticheRequest
     * 
     * @return array
     */
    public function listaPratiche(ListaPraticheRequest $listaPraticheRequest)
    {
        $this->dataPrt['datiPratica']['tipoSportello'] = $listaPraticheRequest->getDatiPratica()->getTipoSportello();
        $this->dataPrt['datiPratica']['tipoPratica'] = $listaPraticheRequest->getDatiPratica()->getTipoPratica();
        $this->dataPrt['aperte'] = $listaPraticheRequest->getAperte();
        $this->dataPrt['filtri'] = $listaPraticheRequest->getFiltri();
        
        $response = $this->client->post('pratica/listaPraticheA2A', [
            'json' => $this->dataPrt
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function listaPraticheServiceUser(ListaPraticheRequest $listaPraticheRequest, $userIdOperativo)
    {
        $this->dataPrt['datiPratica']['tipoSportello'] = $listaPraticheRequest->getDatiPratica()->getTipoSportello();
        $this->dataPrt['datiPratica']['tipoPratica'] = $listaPraticheRequest->getDatiPratica()->getTipoPratica();
        $this->dataPrt['aperte'] = $listaPraticheRequest->getAperte();
        $this->dataPrt['filtri'] = $listaPraticheRequest->getFiltri();

        $response = $this->client->post('pratica/listaPraticheA2A', [
            'query' => [
                'userIdOperativo' => $userIdOperativo,
            ],
            'json' => $this->dataPrt
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Fornisce la lista delle pratiche con richieste di rettifica relative ad un utente
     * 
     * @param \Infocamere\EGov\ListaPraticheRequest $listaPraticheRequest
     * 
     * @return array
     */
    public function listaRettificheRichieste(ListaPraticheRequest $listaPraticheRequest)
    {
        $this->dataPrt['datiPratica']['tipoSportello'] = $listaPraticheRequest->getDatiPratica()->getTipoSportello();
        $this->dataPrt['datiPratica']['tipoPratica'] = $listaPraticheRequest->getDatiPratica()->getTipoPratica();
        $this->dataPrt['aperte'] = $listaPraticheRequest->getAperte();
        $this->dataPrt['filtri'] = $listaPraticheRequest->getFiltri();
        
        $response = $this->client->post('pratica/listaRettificheRichiesteA2A', [
            'json' => $this->dataPrt
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function listaRettificheRichiesteServiceUser(ListaPraticheRequest $listaPraticheRequest, $userIdOperativo)
    {
        $this->dataPrt['datiPratica']['tipoSportello'] = $listaPraticheRequest->getDatiPratica()->getTipoSportello();
        $this->dataPrt['datiPratica']['tipoPratica'] = $listaPraticheRequest->getDatiPratica()->getTipoPratica();
        $this->dataPrt['aperte'] = $listaPraticheRequest->getAperte();
        $this->dataPrt['filtri'] = $listaPraticheRequest->getFiltri();

        $response = $this->client->post('pratica/listaRettificheRichiesteA2AServiceUser', [
            'query' => [
                'userIdOperativo' => $userIdOperativo,
            ],
            'json' => $this->dataPrt
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Rettifica allegato su pratica esistente in stato di rettifica con autenticazione diretta senza creazione di sessione
     * 
     * @param string $idPratica
     * @param \Infocamere\EGov\AggiungiAllegatoRequest $aggiungiAllegatoRequest
     * 
     * @return array
     */
    public function rettificaAllegato($idPratica, AggiungiAllegatoRequest $aggiungiAllegatoRequest)
    {
        $this->dataAll['modelloBaseB64'] = $aggiungiAllegatoRequest->getModelloBase();
        $this->dataAll['allegatoFileName'] = $aggiungiAllegatoRequest->getAllegatoFileName();
        $this->dataAll['descrizioneAllegato'] = $aggiungiAllegatoRequest->getDescrizioneAllegato();
        $this->dataAll['tipoAllegato'] = $aggiungiAllegatoRequest->getTipoAllegato();
        $this->dataAll['rettificaModelloBase'] = $aggiungiAllegatoRequest->isRettificaModelloBase();

        $response = $this->client->put('pratica/rettificaAllegatoA2A', [
            'query' => [
                'idPratica' => $idPratica
            ],
            'json' => $this->dataAll
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function rettificaAllegatoServiceUser($idPratica, AggiungiAllegatoRequest $aggiungiAllegatoRequest, $userIdOperativo)
    {
        $this->dataAll['modelloBaseB64'] = $aggiungiAllegatoRequest->getModelloBase();
        $this->dataAll['allegatoFileName'] = $aggiungiAllegatoRequest->getAllegatoFileName();
        $this->dataAll['descrizioneAllegato'] = $aggiungiAllegatoRequest->getDescrizioneAllegato();
        $this->dataAll['tipoAllegato'] = $aggiungiAllegatoRequest->getTipoAllegato();
        $this->dataAll['rettificaModelloBase'] = $aggiungiAllegatoRequest->isRettificaModelloBase();

        $response = $this->client->put('pratica/rettificaAllegatoA2AServiceUser', [
            'query' => [
                'idPratica' => $idPratica,
                'userIdOperativo' => $userIdOperativo,
            ],
            'json' => $this->dataAll
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Invia rettifica di una pratica con autenticazione diretta senza creazione di sessione
     * 
     * @param string $idPratica
     * 
     * @return array
     */
    public function trasmettiRettifica($idPratica)
    {
        $response = $this->client->post('pratica/rettificaAllegatoA2A', [
            'query' => [
                'idPratica' => $idPratica
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function trasmettiRettificaServiceUser($idPratica, $userIdOperativo)
    {
        $response = $this->client->post('pratica/trasmettiRettificaA2AServiceUser', [
            'query' => [
                'idPratica' => $idPratica,
                'userIdOperativo' => $userIdOperativo,
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Aggiunge il campo note ad una pratica già creata in carico all'utente, con autenticazione diretta senza creazione di sessione 
     * 
     * @param string $idPratica
     * @param string $note
     * 
     * @return array
     */
    public function aggiornaNote($idPratica, $note)
    {
        $response = $this->client->post('pratica/aggiornaNoteA2A', [
            'query' => [
                'idPratica' => $idPratica,
                'note' => $note,
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Restituisce la lista degli sportelli camerali per il dato servzio (es CO) con autenticazione diretta senza creazione di sessione
     * 
     * @param \Infocamere\EGov\Utils\TipoSportello $tipoSportello
     */
    public function listaSportelli($tipoSportello)
    {
        $response = $this->client->post('pratica/listaA2A', [
            'query' => [
                'siglaProvincia' => $tipoSportello,
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function listaSportelliServiceUser($tipoSportello, $userIdOperativo)
    {
        $response = $this->client->post('pratica/listaA2AServiceUser', [
            'query' => [
                'siglaProvincia' => $tipoSportello,
                'userIdOperativo' => $userIdOperativo,
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    /**
     * Restituisce la lista delle sedi distaccate della camera e il servizio indicati con autenticazione diretta senza creazione di sessione
     * 
     * @param strinn $cciaa
     * @param \Infocamere\EGov\Utils\TipoSportello $tipoSportello
     * 
     * @return array
     */
    public function listaSediDistaccate($cciaa, $tipoSportello)
    {
        $cciaa = strtoupper($cciaa);

        $response = $this->client->post('pratica/listaSediA2A', [
            'query' => [
                'siglaProvincia' => $tipoSportello,
                'cciaa' => $cciaa,
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    public function listaSediDistaccateServiceUser($cciaa, $tipoSportello, $userIdOperativo)
    {
        $cciaa = strtoupper($cciaa);
        
        $response = $this->client->post('pratica/listaSediA2A', [
            'query' => [
                'siglaProvincia' => $tipoSportello,
                'cciaa' => $cciaa,
                'userIdOperativo' => $userIdOperativo,
            ]
        ]);
        
        return $this->jsonBody($response->getBody());
    }

    private function jsonBody($body)
    {
        if (!is_null($body)) {
            return json_decode($body->getContents());
        }

        return null;
    }
}