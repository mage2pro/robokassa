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
		// http://docs.robokassa.ru/en/#2503
		// «Идентификатор магазина в ROBOKASSA, который Вы придумали при создании магазина.»
		// http://docs.robokassa.ru/en/#1068
		// Required.
		'MerchantLogin' => $s->merchantID()
		//
		// 2017-04-16
		// «Means the amount payable (in other words, the price of the order placed by the client).
		// The format of presentation – dot-delimited digits. For example 123.45.
		// The amount should be denominated in RUB.
		// However, if the prices are denominated (e.g.) in USD on your website
		// when issuing the invoice you need to specify the amount converted from USD to RUB.
		// (see Optional Parameters OutSumCurrency).»
		// http://docs.robokassa.ru/en/#2504
		// «Требуемая к получению сумма (буквально — стоимость заказа, сделанного клиентом).
		// Формат представления — число, разделитель — точка, например: 123.45.
		// Сумма должна быть указана в рублях.
		// Но, если стоимость товаров у Вас на сайте указана, например, в долларах,
		// то при выставлении счёта к оплате Вам необходимо указывать уже пересчитанную сумму
		// из долларов в рубли. См. необязательный параметр OutSumCurrency.»
		// http://docs.robokassa.ru/#1188
		// Required.
		,'OutSum' => $this->amountF()
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