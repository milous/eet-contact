<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


class Company implements ICompany
{

	private $dic_popl = '';

	/**
	 * @var string|null
	 */
	private $dic_poverujiciho;

	private $id_provoz = '';

	public $id_pokl = '';

	public function getDicPopl() : string
	{
		return $this->dic_popl;
	}

	/**
	 * @return string|null
	 */
	public function getDicPoverujiciho()
	{
		return $this->dic_poverujiciho;
	}

	public function getIdProvoz() : string
	{
		return $this->id_provoz;
	}

	public function getIdPokl() : string
	{
		return $this->id_pokl;
	}

	public function setDicPopl(string $dic_popl) : self
	{
		$this->dic_popl = $dic_popl;
		return $this;
	}

	public function setDicPoverujiciho(string $dic_poverujiciho) : self
	{
		$this->dic_poverujiciho = $dic_poverujiciho;
		return $this;
	}

	public function setIdProvoz(string $id_provoz) : self
	{
		$this->id_provoz = $id_provoz;
		return $this;
	}

	public function setIdPokl(string $id_pokl) : self
	{
		$this->id_pokl = $id_pokl;
		return $this;
	}

}
