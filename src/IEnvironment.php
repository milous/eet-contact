<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


interface IEnvironment
{

	public function getPrivateKey() : string;

	public function getCertificate() : string;

	public function getService() : string;

}
