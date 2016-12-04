<?php

namespace FilipSedivy\EET;

use FilipSedivy\EET\Exceptions\ClientException;
use FilipSedivy\EET\Exceptions\RequirementsException;
use FilipSedivy\EET\Exceptions\ServerException;
use FilipSedivy\EET\SoapClient;
use FilipSedivy\EET\Utils\Format;
use RobRichards\XMLSecLibs\XMLSecurityKey;

/**
 * Receipt for Ministry of Finance
 */
class Dispatcher {

	/**
	 * @var IEnvironment
	 */
	private $environment;

    /**
     * @var boolean
     */
    public $trace;

    /**
     *
     * @var SoapClient
     */
    private $soapClient;


    public function __construct(IEnvironment $environment)
    {
        $this->checkRequirements();
	    $this->environment = $environment;
    }

    public function check(IMessage $message) : bool
    {
        try {
            return (bool) $this->send($message->getOvereni() ? $message : (clone $message));
        } catch (ServerException $e) {
            return FALSE;
        }
    }

    /**
     *
     * @param boolean $tillLastRequest optional If not set/FALSE connection time till now is returned.
     * @return float
     */
    public function getConnectionTime($tillLastRequest = FALSE) {
        !$this->trace && $this->throwTraceNotEnabled();
        return $this->getSoapClient()->__getConnectionTime($tillLastRequest);
    }

    /**
     *
     * @return int
     */
    public function getLastResponseSize() {
        !$this->trace && $this->throwTraceNotEnabled();
        return mb_strlen($this->getSoapClient()->__getLastResponse(), '8bit');
    }

    /**
     *
     * @return int
     */
    public function getLastRequestSize() {
        !$this->trace && $this->throwTraceNotEnabled();
        return mb_strlen($this->getSoapClient()->__getLastRequest(), '8bit');
    }

    /**
     *
     * @return float time in ms
     */
    public function getLastResponseTime() {
        !$this->trace && $this->throwTraceNotEnabled();
        return $this->getSoapClient()->__getLastResponseTime();
    }

    /**
     *
     * @throws ClientException
     */
    private function throwTraceNotEnabled() {
        throw new ClientException('Trace is not enabled! Set trace property to TRUE.');
    }


    public function getCheckCodes(IMessage $message) : array
    {
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
        $objKey->loadKey($this->environment->getPrivateKey());

	    $receipt = $message->getReceipt();
	    $company = $receipt->getCompany();

        $arr = [
            $company->getDicPopl(),
            $company->getIdProvoz(),
            $company->getIdPokl(),
            $receipt->getPoradCis(),
            $receipt->getDatTrzby()->format('c'),
	        Format::price($receipt->getCelkTrzba()),
        ];
        $sign = $objKey->signData(join('|', $arr));

        return [
            'pkp' => [
                '_' => $sign,
                'digest' => 'SHA256',
                'cipher' => 'RSA2048',
                'encoding' => 'base64'
            ],
            'bkp' => [
                '_' => Format::BKB(sha1($sign)),
                'digest' => 'SHA1',
                'encoding' => 'base16'
            ]
        ];
    }


    public function send(IMessage $message) : string
    {
        $this->initSoapClient();

        $response = $this->processData($message);

        isset($response->Chyba) && $this->processError($response->Chyba);

        return $message->getOvereni() ? '1' : $response->Potvrzeni->fik;
    }

    /**
     *
     * @throws RequirementsException
     * @return void
     */
    private function checkRequirements() {
        if (!class_exists('\SoapClient')) {
            throw new RequirementsException('Class SoapClient is not defined! Please, allow php extension php_soap.dll in php.ini');
        }
    }

    /**
     * Get (or if not exists: initialize and get) SOAP client.
     *
     * @return SoapClient
     */
    public function getSoapClient() {
        !isset($this->soapClient) && $this->initSoapClient();
        return $this->soapClient;
    }

    /**
     * Require to initialize a new SOAP client for a new request.
     *
     * @return void
     */
    private function initSoapClient() {
        if ($this->soapClient === NULL) {
            $this->soapClient = new SoapClient($this->environment, $this->trace);
        }
    }

    public function prepareData(IMessage $message) : array
    {
        $head = [
            'uuid_zpravy' => $message->getUuidZpravy(),
            'dat_odesl' => time(),
            'prvni_zaslani' => $message->getPrvniZaslani(),
            'overeni' => $message->getOvereni(),
        ];

	    $receipt = $message->getReceipt();
	    $company = $receipt->getCompany();

        $body = [
            'dic_popl' => $company->getDicPopl(),
            'dic_poverujiciho' => $company->getDicPoverujiciho(),
            'id_provoz' => $company->getIdProvoz(),
            'id_pokl' => $company->getIdPokl(),
            'porad_cis' => $receipt->getPoradCis(),
            'dat_trzby' => $receipt->getDatTrzby()->format('c'),
            'celk_trzba' => Format::price($receipt->getCelkTrzba()),
            'zakl_nepodl_dph' => Format::price($receipt->getZaklNepodlDph()),
            'zakl_dan1' => Format::price($receipt->getZaklDan1()),
            'dan1' => Format::price($receipt->getDan1()),
            'zakl_dan2' => Format::price($receipt->getZaklDan2()),
            'dan2' => Format::price($receipt->getDan2()),
            'zakl_dan3' => Format::price($receipt->getZaklDan3()),
            'dan3' => Format::price($receipt->getDan3()),
            'cest_sluz' => Format::price($receipt->getCestSluz()),
            'pouzit_zboz1' => Format::price($receipt->getPouzitZboz1()),
            'pouzit_zboz2' => Format::price($receipt->getPouzitZboz2()),
            'pouzit_zboz3' => Format::price($receipt->getPouzitZboz3()),
            'urceno_cerp_zuct' => Format::price($receipt->getUrcenoCerpZuct()),
            'cerp_zuct' => Format::price($receipt->getCerpZuct()),
	        'rezim' => $message->getRezim(),
        ];

        return [
            'Hlavicka' => $head,
            'Data' => $body,
            'KontrolniKody' => $this->getCheckCodes($message)
        ];
    }

    private function processData(IMessage $message) : \stdClass
    {
        $data = $this->prepareData($message);

        return $this->getSoapClient()->OdeslaniTrzby($data);
    }

    /**
     * @param $error
     * @throws ServerException
     */
    private function processError($error) {
        if ($error->kod) {
            $msgs = [
                -1 => 'Docasna technicka chyba zpracovani – odeslete prosim datovou zpravu pozdeji',
                2 => 'Kodovani XML neni platne',
                3 => 'XML zprava nevyhovela kontrole XML schematu',
                4 => 'Neplatny podpis SOAP zpravy',
                5 => 'Neplatny kontrolni bezpecnostni kod poplatnika (BKP)',
                6 => 'DIC poplatnika ma chybnou strukturu',
                7 => 'Datova zprava je prilis velka',
                8 => 'Datova zprava nebyla zpracovana kvuli technicke chybe nebo chybe dat',
            ];
            $msg = isset($msgs[$error->kod]) ? $msgs[$error->kod] : '';
            throw new ServerException($msg, $error->kod);
        }
    }

}
