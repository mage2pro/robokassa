<?php
namespace Dfe\Robokassa;
/**
 * 2017-04-10
 * @see \Dfe\Robokassa\Signer\Request
 * @see \Dfe\Robokassa\Signer\Response
 * @method Settings s()
 */
abstract class Signer extends \Df\PaypalClone\Signer {
	/**
	 * 2017-04-10
	 * @used-by self::sign()
	 * @see \Dfe\Robokassa\Signer\Request::values()
	 * @see \Dfe\Robokassa\Signer\Response::values()
	 * @return string[]
	 */
	abstract protected function values():array;

	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\PaypalClone\Signer::sign()
	 * @used-by \Df\PaypalClone\Signer::_sign()
	 */
	final protected function sign():string {return md5(implode(':', dfa_flatten($this->values())));}
}