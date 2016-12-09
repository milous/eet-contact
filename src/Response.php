<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


class Response
{
	/**
	 * @var \stdClass
	 */
	private $rawData;

	/**
	 * @var IMessage
	 */
	protected $request;

	public function __construct(\stdClass $rawData, IMessage $request)
	{
		$this->rawData = $rawData;
		$this->request = $request;
	}


	public function getRawData(): \stdClass
	{
		return $this->rawData;
	}


	public function getRequest(): IMessage
	{
		return $this->request;
	}


	public function isError() : bool
	{
		return $this->getErrorCode() !== 0;
	}


	public function getFik() : string
	{
		return $this->isError() ? '' : $this->rawData->Potvrzeni->fik;
	}


	public function getErrorMessage() : string
	{
		$errors = [
			-1 => 'Docasna technicka chyba zpracovani – odeslete prosim datovou zpravu pozdeji',
			0 => '',
			2 => 'Kodovani XML neni platne',
			3 => 'XML zprava nevyhovela kontrole XML schematu',
			4 => 'Neplatny podpis SOAP zpravy',
			5 => 'Neplatny kontrolni bezpecnostni kod poplatnika (BKP)',
			6 => 'DIC poplatnika ma chybnou strukturu',
			7 => 'Datova zprava je prilis velka',
			8 => 'Datova zprava nebyla zpracovana kvuli technicke chybe nebo chybe dat',
		];

		return $errors[$this->getErrorCode()] ?? 'neznámé číslo chyby';
	}


	public function getErrorCode() : int
	{
		return isset($this->rawData->Chyba) ? $this->rawData->Chyba->kod : 0;
	}


	public function __toString()
	{
		return $this->getFik();
	}


}
