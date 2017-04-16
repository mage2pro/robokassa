<?php
namespace Dfe\Robokassa\Signer;
// 2017-04-10
// 2017-04-16
// SignatureValue –  checksum or hash sum, a line of a 32-bit 16-nary number
// in hex format and any register (totally 32 characters 0-9, A-F)
// calculated by the method specified in the Technical Settings of the shop.
// It is generated in the line containing the following parameters delimited by ‘:’ followed by Password#1
// (you prescribed this password when completing section Technical Settings):
// MerchantLogin:OutSum:InvId:Password#1 — if the parameter InvId has been transmitted,
// and: MerchantLogin:OutSum::Password#1 if the parameter InvId has not been transmitted.
// This is a very important parameter which ensures the security of payment
// and integrity of data transmission.
// If it is correctly compiled, no intruder will be able to forge any data in the payment transaction.
// http://docs.robokassa.ru/en#2506
//
// «Контрольная сумма - хэш, число в 16-ричной форме и любом регистре (0-9, A-F),
// рассчитанное методом указанным в Технических настройках магазина.
// Рассчитывается по базе, содержащей следующие параметры, разделенные символом ':',
// с добавлением Пароль#1  — (этот пароль Вы придумали, на этапе заполнения раздела Технические настройки):
// MerchantLogin:OutSum:InvId:Пароль#1  — если параметр InvId был передан,
// и: MerchantLogin:OutSum::Пароль#1 — если параметр InvId передан не был.
// Это очень важный параметр, который обеспечивает безопасность при прохождении платежа
// и целостность передаваемых данных.
// Корректное его составление гарантирует, что злоумышленник не сможет подделать какие-либо данные
// в операции оплаты.»
// http://docs.robokassa.ru/ru#1190
final class Request extends \Dfe\Robokassa\Signer {
	/**
	 * 2017-04-10
	 * @override
	 * @see \Dfe\Robokassa\Signer::values()
	 * @used-by \Dfe\Robokassa\Signer::sign()
	 * @return string[]
	 */
	protected function values() {return [
		dfa_select_ordered($this->v(), ['MerchantLogin', 'OutSum', 'InvId', 'UserIP'])
		,$this->s()->password1()
	];}
}