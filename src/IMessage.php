<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


interface IMessage
{

	public function getUuidZpravy() : string;

	public function getPrvniZaslani() : bool;

	public function getRezim() : bool;

	public function getReceipt() : IReceipt;

	public function getOvereni() : bool;

}
