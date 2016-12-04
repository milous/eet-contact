<?php
/**
 * Copyright (c) 2016 Milan Otáhal su@milous.cz
 */

namespace FilipSedivy\EET;


interface IReceipt {

	public function getCompany() : ICompany;

	public function getDatTrzby() : \DateTime;

	public function getPoradCis() : int;

	public function getCelkTrzba() : float;

	public function getZaklNepodlDph() : float;

	public function getZaklDan1() : float;

	public function getDan1() : float;

	public function getZaklDan2() : float;

	public function getDan2() : float;

	public function getZaklDan3() : float;

	public function getDan3() : float;

	public function getCestSluz() : float;

	public function getPouzitZboz1() : float;

	public function getPouzitZboz2() : float;

	public function getPouzitZboz3() : float;

	public function getUrcenoCerpZuct() : float;

	public function getCerpZuct() : float;

}
