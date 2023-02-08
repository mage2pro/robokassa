<?php
namespace Dfe\Robokassa\Block;
# 2017-04-10
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Info extends \Df\Payment\Block\Info {
	/**
	 * 2017-04-10
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::prepareToRendering()
	 */
	final protected function prepare():void {$this->si('Payment Option', $this->choiceT());}
}