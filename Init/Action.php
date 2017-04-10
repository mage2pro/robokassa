<?php
namespace Dfe\Robokassa\Init;
// 2017-04-10
/** @method \Dfe\Robokassa\Method m() */
final class Action extends \Df\PaypalClone\Init\Action {
	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @return string
	 */
	protected function redirectUrl() {return '';}
}