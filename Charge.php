<?php
namespace Dfe\Robokassa;
/**
 * 2017-04-10
 * 2017-04-16
 * «Description of variables, parameters and values»: http://docs.robokassa.ru/en/#2501
 * «Описание переменных, параметров и значений»: http://docs.robokassa.ru/#1061
 * @method Method m()
 * @method Settings s()
 */
final class Charge extends \Df\PaypalClone\Charge {
	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\PaypalClone\Charge::pCharge()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return array(string => mixed)
	 */
	protected function pCharge() {$s = $this->s(); return [
		// 2017-04-16
		// «Means the Shop Identifier in ROBOKASSA you specified upon creation of the Shop.»
		// «Идентификатор магазина в ROBOKASSA, который Вы придумали при создании магазина.»
		'MerchantLogin' => $s->merchantID()
	];}

	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\PaypalClone\Charge::k_RequestId()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_RequestId() {return '';}

	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\PaypalClone\Charge::k_Signature()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_Signature() {return '';}
}