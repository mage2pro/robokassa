<?php
namespace Dfe\Robokassa\W;
use Dfe\Robokassa\Api\Options;
use Magento\Framework\App\ScopeInterface as IScope;
use Magento\Store\Model\Store;
/**
 * 2017-04-16
 * 2017-08-14
 * As I understand from the documentation, Robokassa does not send an «offine» event for a pending payment.
 * If a customer has chosen to pay offline,
 * then Robokassa will send event to us only then the payment is actually done.
 * «Проводить подтверждение оплаты у себя по базе и все остальные действия, связанные с выдачей покупки,
 * Вам нужно при получении уведомления на ResultURL,
 * потому что именно на него ROBOKASSA передаёт подтверждающие данные об оплате.»
 * https://docs.robokassa.ru/ru#1261
 */
final class Event extends \Df\PaypalClone\W\Event {
	/**
	 * 2017-04-17
	 * @used-by \Dfe\Robokassa\Choice::title()
	 * @param null|string|int|IScope|Store $s [optional]
	 */
	function optionTitle($s = null):string {return dftr($this->r('IncCurrLabel'), Options::map($s));}

	/**
	 * 2017-04-16
	 * Robokassa не возвращают своего идентификатора для платежей (возвращают только идентификатор, заданный магазином).
	 * Для таких ПС метод должен возвращать null, и тогда формируем псевдо-идентификатор платежа в ПС самостоятельно,
	 * Он будет использован только для присвоения в качестве txn_id текущей транзакции.
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_idE()
	 * @used-by \Df\PaypalClone\W\Event::idE()
	 */
	protected function k_idE():string {return '';}

	/**
	 * 2017-04-16
	 * «Means your invoice number»: http://docs.robokassa.ru/en#2542
	 * «Номер счета в магазине»: http://docs.robokassa.ru/ru#1252
	 * @override
	 * @see \Df\Payment\W\Event::k_pid()
	 * @used-by \Df\Payment\W\Event::pid()
	 */
	protected function k_pid():string {return 'InvId';}

	/**
	 * 2017-04-16
	 * «Means your invoice number»: http://docs.robokassa.ru/en#2543
	 * «Номер счета в магазине»: http://docs.robokassa.ru/ru#1253
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_signature()
	 * @used-by \Df\PaypalClone\W\Event::signatureProvided()
	 */
	protected function k_signature():string {return 'SignatureValue';}

	/**
	 * 2017-04-16
	 * 2017-08-14 Robokassa does not return a payment's status.
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_status()
	 * @used-by \Df\PaypalClone\W\Event::status()
	 */
	protected function k_status():string {return '';}
}