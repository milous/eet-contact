<?php

namespace FilipSedivy\EET;

use FilipSedivy\EET\Exceptions\ClientException;

/**
 * Parsování PKCS#12 a uchování X.509 certifikátu
 *
 * @author Filip Šedivý <mail@filipsedivy.cz>
 * @version 1.0.1
*/
class Environment implements IEnvironment
{
    private $privateKey;

    private $certificate;

	private $service;

	public function __construct(string $certificate, string $password, string $service)
    {
        if(!file_exists($certificate)){
            throw new ClientException("Certifikat nebyl nalezen");
        }

        $certs = [];
        $pkcs12 = file_get_contents($certificate);

        $openSSL = openssl_pkcs12_read($pkcs12, $certs, $password);
        if(!$openSSL)
        {
            throw new ClientException("Certifikat se nepodarilo vyexportovat.");
        }

        $this->privateKey = $certs['pkey'];
        $this->certificate = $certs['cert'];

	    $this->service = $service;
    }

    public function getPrivateKey() : string
    {
        return $this->privateKey;
    }

    public function getCertificate() : string
    {
        return $this->certificate;
    }

	public function getService() : string
	{
		return $this->service;
	}
}
