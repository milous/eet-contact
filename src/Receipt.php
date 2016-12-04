<?php

namespace FilipSedivy\EET;


class Receipt implements IReceipt {

	/**
	 * @var ICompany
	 */
	private $company;

	/**
	 * @var \DateTime
	 */
	private $dat_trzby;

    private $porad_cis = 0;

    private $celk_trzba = 0.0;
	
    private $zakl_nepodl_dph = 0.0;
	
    private $zakl_dan1 = 0.0;

    private $dan1 = 0.0;

    private $zakl_dan2 = 0.0;

    private $dan2 = 0.0;

    private $zakl_dan3 = 0.0;

    private $dan3 = 0.0;

    private $cest_sluz = 0.0;

    private $pouzit_zboz1 = 0.0;

    private $pouzit_zboz2 = 0.0;

    private $pouzit_zboz3 = 0.0;

    private $urceno_cerp_zuct = 0.0;

    private $cerp_zuct = 0.0;

	public function getCompany(): ICompany
	{
		return $this->company;
	}

	public function getPoradCis(): int
	{
		return $this->porad_cis;
	}

	public function getDatTrzby(): \DateTime
	{
		return $this->dat_trzby;
	}

	public function getCelkTrzba(): float
	{
		return $this->celk_trzba;
	}

	public function getZaklNepodlDph(): float
	{
		return $this->zakl_nepodl_dph;
	}

	public function getZaklDan1(): float
	{
		return $this->zakl_dan1;
	}

	public function getDan1(): float
	{
		return $this->dan1;
	}

	public function getZaklDan2(): float
	{
		return $this->zakl_dan2;
	}

	public function getDan2(): float
	{
		return $this->dan2;
	}

	public function getZaklDan3(): float
	{
		return $this->zakl_dan3;
	}

	public function getDan3(): float
	{
		return $this->dan3;
	}

	public function getCestSluz(): float
	{
		return $this->cest_sluz;
	}

	public function getPouzitZboz1(): float
	{
		return $this->pouzit_zboz1;
	}

	public function getPouzitZboz2(): float
	{
		return $this->pouzit_zboz2;
	}

	public function getPouzitZboz3(): float
	{
		return $this->pouzit_zboz3;
	}

	public function getUrcenoCerpZuct(): float
	{
		return $this->urceno_cerp_zuct;
	}

	public function getCerpZuct(): float
	{
		return $this->cerp_zuct;
	}

	public function setCompany(ICompany $company) : self
	{
		$this->company = $company;
		return $this;
	}

	public function setPoradCis(int $porad_cis) : self
	{
		$this->porad_cis = $porad_cis;
		return $this;
	}

	public function setDatTrzby(\DateTime $dat_trzby) : self
	{
		$this->dat_trzby = $dat_trzby;
		return $this;
	}

	public function setCelkTrzba(float $celk_trzba) : self
	{
		$this->celk_trzba = $celk_trzba;
		return $this;
	}

	public function setZaklNepodlDph(float $zakl_nepodl_dph) : self
	{
		$this->zakl_nepodl_dph = $zakl_nepodl_dph;
		return $this;
	}

	public function setZaklDan1(float $zakl_dan1) : self
	{
		$this->zakl_dan1 = $zakl_dan1;
		return $this;
	}

	public function setDan1(float $dan1) : self
	{
		$this->dan1 = $dan1;
		return $this;
	}

	public function setZaklDan2(float $zakl_dan2) : self
	{
		$this->zakl_dan2 = $zakl_dan2;
		return $this;
	}

	public function setDan2(float $dan2) : self
	{
		$this->dan2 = $dan2;
		return $this;
	}

	public function setZaklDan3(float $zakl_dan3) : self
	{
		$this->zakl_dan3 = $zakl_dan3;
		return $this;
	}

	public function setDan3(float $dan3) : self
	{
		$this->dan3 = $dan3;
		return $this;
	}

	public function setCestSluz(float $cest_sluz) : self
	{
		$this->cest_sluz = $cest_sluz;
		return $this;
	}

	public function setPouzitZboz1(float $pouzit_zboz1) : self
	{
		$this->pouzit_zboz1 = $pouzit_zboz1;
		return $this;
	}

	public function setPouzitZboz2(float $pouzit_zboz2) : self
	{
		$this->pouzit_zboz2 = $pouzit_zboz2;
		return $this;
	}

	public function setPouzitZboz3(float $pouzit_zboz3) : self
	{
		$this->pouzit_zboz3 = $pouzit_zboz3;
		return $this;
	}

	public function setUrcenoCerpZuct(float $urceno_cerp_zuct) : self
	{
		$this->urceno_cerp_zuct = $urceno_cerp_zuct;
		return $this;
	}

	public function setCerpZuct(float $cerp_zuct) : self
	{
		$this->cerp_zuct = $cerp_zuct;
		return $this;
	}

}
