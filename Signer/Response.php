<?php
namespace Dfe\Robokassa\Signer;
// 2017-04-10
// 2017-04-16
// «Контрольная сумма - хэш, число в 16-ричной форме и любом регистре (0-9, A-F),
// рассчитанное методом указанным в Технических настройках магазина.
// База для расчёта контрольной суммы: OutSum:InvId:Пароль#2 —
// если Вы не передавали пользовательские параметры.»
// http://docs.robokassa.ru/ru#1253
final class Response extends \Dfe\Robokassa\Signer {
	/**
	 * 2017-04-10
	 * @override
	 * @see \Dfe\Robokassa\Signer::values()
	 * @used-by \Dfe\Robokassa\Signer::sign()
	 * @return string[]
	 */
	protected function values() {return [dfa($this->v(), ['OutSum', 'InvId']), $this->s()->password2()];}
}