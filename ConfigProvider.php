<?php
namespace Dfe\Robokassa;
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
		'options' => $this->options()
	] + parent::config();}

	/**
	 * 2017-04-15
	 * @used-by config()
	 * @return array(string => mixed)
	 */
	private function options() {return array_values(df_map_k(function($k, array $v) {return [
		'children' => df_map(function(array $i) {return [
			'label' => $i['Name'], 'value' => $i['Label']
		];}, $v['items'])
		,'label' => $v['title'], 'value' => $k
	];}, \Dfe\Robokassa\Api\Options::p()));}
}