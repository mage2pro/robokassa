<?php
namespace Dfe\Robokassa;
use Dfe\Robokassa\Api\Options;
// 2017-04-10
final class ConfigProvider extends \Df\Payment\ConfigProvider {
	/**
	 * 2017-04-12
	 * @override
	 * @see \Df\Payment\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config() {/** @var Settings $s */ $s = $this->s(); return [
		'options' => Options::forCheckout($this->amount())
	] + parent::config();}
}