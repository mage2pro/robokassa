<?php
namespace Dfe\Robokassa;
// 2017-04-10
final class Method extends \Df\PaypalClone\Method {
	/**
	 * 2017-04-16
	 * «The format of presentation – dot-delimited digits. For example 123.45.»
	 * http://docs.robokassa.ru/en#2504
	 * «Формат представления — число, разделитель — точка, например: 123.45.»
	 * http://docs.robokassa.ru#1188
	 * @override
	 * @see \Df\Payment\Method::amountFormat()
	 * @used-by \Df\Payment\Operation::amountFormat()
	 * @param float|int $a
	 * @return string
	 */
	function amountFormat($a) {return df_f2($a);}

	/**
	 * 2017-04-16
	 * @used-by \Dfe\Robokassa\Charge::pCharge()
	 * @return string
	 */
	function option() {return df_result_sne($this->iia(self::$II_OPTION));}

	/**
	 * 2017-04-16
	 * «The format of presentation – dot-delimited digits. For example 123.45.»
	 * http://docs.robokassa.ru/en#2504
	 * «Формат представления — число, разделитель — точка, например: 123.45.»
	 * http://docs.robokassa.ru#1188
	 * @override
	 * @see \Df\Payment\Method::amountFactor()
	 * @used-by \Df\Payment\Method::amountFormat()
	 * @used-by \Df\Payment\Method::amountParse()
	 * @return int
	 */
	protected function amountFactor() {return 1;}

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