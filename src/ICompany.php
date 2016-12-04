<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


interface ICompany
{

	public function getDicPopl() : string;

	/**
	 * @return string|null
	 */
	public function getDicPoverujiciho();

	public function getIdProvoz() : string;

	public function getIdPokl() : string;

}
