<?php
namespace Dfe\Robokassa;
// 2017-04-10
final class Method extends \Df\PaypalClone\Method {
	/**
	 * 2017-04-16
	 * @used-by \Dfe\Robokassa\Charge::pCharge()
	 * @return string
	 */
	function option() {return df_result_sne($this->iia(self::$II_OPTION));}

	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\Payment\Method::amountLimits()
	 * @used-by \Df\Payment\Method::isAvailable()
	 * @return null
	 */
	protected function amountLimits() {return null;}

	/**
	 * 2017-04-16
	 * @override
	 * @see \Df\Payment\Method::iiaKeys()
	 * @used-by \Df\Payment\Method::assignData()
	 * @return string[]
	 */
	protected function iiaKeys() {return [self::$II_OPTION];}

	/**
	 * 2017-04-16
	 * https://github.com/mage2pro/core/blob/2.0.36/Payment/view/frontend/web/withOptions.js?ts=4#L23
	 * @used-by iiaKeys()
	 * @used-by option()
	 */
	private static $II_OPTION = 'option';
}