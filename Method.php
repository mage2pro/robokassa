<?php
namespace Dfe\Robokassa;
# 2017-04-10
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
	 */
	function amountFormat(float $a):string {return dff_2($a);}

	/**
	 * 2017-04-16
	 * @used-by \Dfe\Robokassa\Charge::pCharge()
	 */
	function option():string {return df_result_sne($this->iia(self::$II_OPTION));}

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
	 */
	protected function amountFactor():int {return 1;}

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
	protected function iiaKeys():array {return [self::$II_OPTION];}

	/**
	 * 2017-04-16 https://github.com/mage2pro/core/blob/2.12.17/Payment/view/frontend/web/withOptions.js#L56-L72
	 * @used-by self::iiaKeys()
	 * @used-by self::option()
	 */
	private static $II_OPTION = 'option';
}