<?php
namespace Dfe\Robokassa;
use Df\Payment\ConfigProvider\IOptions;
use Dfe\Robokassa\Api\Options;
# 2017-04-10
final class ConfigProvider extends \Df\Payment\ConfigProvider implements IOptions {
	/**
	 * 2017-09-18
	 * @override
	 * @see \Df\Payment\ConfigProvider\IOptions::options()
	 * @used-by \Df\Payment\ConfigProvider::configOptions()
	 * @return array(array('label' => string, 'value' => int|string, 'children' => <...>))
	 */
	function options():array {return Options::forCheckout($this->amount());}

	/**
	 * 2017-04-12
	 * @override
	 * @see \Df\Payment\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config():array {return self::configOptions($this) + parent::config();}
}