<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


class Message implements IMessage
{
	/**
	 * @var IReceipt
	 */
	private $receipt;

	private $uuid_zpravy = '';

	private $prvni_zaslani = TRUE;

	private $rezim = FALSE;

	private $overeni = FALSE;

	public function getUuidZpravy() : string
	{
		return $this->uuid_zpravy;
	}

	public function getPrvniZaslani() : bool
	{
		return $this->prvni_zaslani;
	}

	public function getRezim() : bool
	{
		return $this->rezim;
	}

	public function getReceipt() : IReceipt
	{
		return $this->receipt;
	}

	public function getOvereni(): bool
	{
		return $this->overeni;
	}

	public function setUuidZpravy(string $uuid_zpravy) : self
	{
		$this->uuid_zpravy = $uuid_zpravy;
		return $this;
	}

	public function setPrvniZaslani(bool $prvni_zaslani = TRUE) : self
	{
		$this->prvni_zaslani = $prvni_zaslani;
		return $this;
	}

	public function setRezim(bool $rezim = FALSE) : self
	{
		$this->rezim = $rezim;
		return $this;
	}

	public function setReceipt(IReceipt $receipt) : self
	{
		$this->receipt = $receipt;
		return $this;
	}

	public function setOvereni(bool $overeni) : self
	{
		$this->overeni = $overeni;
		return $this;
	}
	
}
