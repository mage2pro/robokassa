<?php
namespace Dfe\Robokassa;
// 2017-04-10
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-04-12
	 * «Password #1»
	 * [Robokassa] Where are my API credentials and settings located? https://mage2.pro/t/3667
	 * @return string
	 */
	function password1() {return $this->testableP();}

	/**
	 * 2017-04-12
	 * «Password #2»
	 * [Robokassa] Where are my API credentials and settings located? https://mage2.pro/t/3667
	 * @return string
	 */
	function password2() {return $this->testableP();}
}