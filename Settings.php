<?php
namespace Dfe\Robokassa;
# 2017-04-10
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-04-12
	 * «Password #1».
	 * «This is for the payment initiation interface.
	 * It must by at least 8 characters long and contain at least one letter and one digit.»
	 * http://docs.robokassa.ru/en#5197
	 * [Robokassa] Where are my API credentials and settings located? https://mage2.pro/t/3667
	 * @used-by \Dfe\Robokassa\Signer\Request::values()
	 */
	function password1():string {return $this->testableP();}

	/**
	 * 2017-04-12
	 * «Password #2».
	 * «This is for the payment notification interface and XML-interfaces.
	 * It must by at least 8 characters long and contain at least one letter and one digit.»
	 * http://docs.robokassa.ru/en#5197
	 * [Robokassa] Where are my API credentials and settings located? https://mage2.pro/t/3667
	 * @used-by \Dfe\Robokassa\Signer\Response::values()
	 * @return string
	 */
	function password2() {return $this->testableP();}
}