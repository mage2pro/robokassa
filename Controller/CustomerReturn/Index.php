<?php
namespace Dfe\Robokassa\Controller\CustomerReturn;
// 2017-04-13
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Index extends \Df\Payment\CustomerReturn {
	/**
	 * 2017-04-16
	 * Robokassa не присылает IPN в случае сбоя,
	 * поэтому в момент возвращения покупателя в магазин после неудачной попытки оплаты заказа
	 * заказ ещё не отменён, и нам нужно именно здесь установить факт неудачности.
	 * Подпись присутствует, если Robokassa перенаправила пользователя по Success URL,
	 * и отсутствует, если Robokassa перенаправила пользователя по Fail URL.
	 * Корректность подписи нам проверять здесь не нужно:
	 * потому что факт оплаты мы удостоверяем при обработке Result URL,
	 * а здесь нам лишь надо знать, ждать ли дальше оплаты или же сразу отменять заказ.
	 * Если пользователь перешёл по Success URL — ждём оплату (ждём оповещений по Result URL),
	 * а если пользователь перешёл по Fail URL, то сразу отменяем заказ.
	 * @override
	 * @see \Df\Payment\CustomerReturn::isSuccess()
	 * @used-by \Df\Payment\CustomerReturn::execute()
	 * @return string
	 */
	final protected function isSuccess() {return !!df_request('SignatureValue');}
}