<?php
namespace Dfe\Robokassa\Signer;
// 2017-04-10
final class Request extends \Dfe\Robokassa\Signer {
	/**
	 * 2017-04-10
	 * @override
	 * @see \Dfe\Robokassa\Signer::values()
	 * @used-by \Dfe\Robokassa\Signer::sign()
	 * @return string[]
	 */
	protected function values() {return dfa_select_ordered($this->v(), []);}
}