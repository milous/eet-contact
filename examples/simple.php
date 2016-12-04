<?php

require_once __DIR__.'/../../../../vendor/autoload.php';

define('Playground', __DIR__.'/../src/Schema/PlaygroundService.wsdl');
define('Production', __DIR__.'/../src/Schema/ProductionService.wsdl');

use FilipSedivy\EET\Dispatcher;
use FilipSedivy\EET\Receipt;
use FilipSedivy\EET\Utils\UUID;
use FilipSedivy\EET\Message;
use FilipSedivy\EET\Company;
use FilipSedivy\EET\Environment;

$environment = new Environment(
	__DIR__ . '/EET_CA1_Playground-CZ00000019.p12',
	'eet',
	Playground
);

$dispatcher = new Dispatcher($environment);
$dispatcher->trace = true;

$uuid = UUID::v4();

$company = new Company;
$company->setDicPopl('CZ1212121218');
$company->setIdPokl('IP105');
$company->setIdProvoz('11');

$receipt = new Receipt;
$receipt->setCompany($company);
$receipt->setPoradCis(1);
$receipt->setDatTrzby(new \DateTime());
$receipt->setCelkTrzba(500.0);

$message = new Message;
$message->setUuidZpravy($uuid);
$message->setReceipt($receipt);

echo '<h2>---REQUEST---</h2>';
echo "<pre>";
try {
    $fik = $dispatcher->send($message);
    echo sprintf('<b>Returned FIK code: %s</b><br />', $fik);
} catch (\FilipSedivy\EET\Exceptions\ServerException $e) {
    var_dump($e); // See exception
} catch (\Exception $e) {
    var_dump($e); // Fatal error
}
echo sprintf('Request size: %d bytes | Response size: %d bytes | Response time: %f ms | Connection time: %f ms<br />', $dispatcher->getLastRequestSize(), $dispatcher->getLastResponseSize(), $dispatcher->getLastResponseTime(), $dispatcher->getConnectionTime()); // Size of transferred data
