<?php
namespace Dfe\Robokassa\Api;
use Df\Xml\X;
use Magento\Framework\App\ScopeInterface as IScope;
use Magento\Store\Model\Store;
// 2017-04-12
final class Options {
	/**
	 * 2017-04-15
	 * 2017-04-16
	 * В качестве кода способа оплаты стал использовать значение атрибута «Alias» вместо «Label»,
	 * потому что заметил, что «Label» может иметь разное значение при разных идентификаторах магазина.
	 * Например, способ оплаты банковской картой для магазина «demo» описан так:
	 * <Currency Label="BANKOCEAN3R" Alias="BankCard" Name="Bank Card"/>
	 * А для моего магазина «2016-10-18-2» он описан так:
	 * <Currency Label="QCardR" Alias="BankCard" Name="Bank Card"/>
	 * @used-by config()
	 * @return array(string => mixed)
	 */
	static function forCheckout() {return array_values(df_map_k(function($k, array $v) {return [
		'children' => df_map(function(array $i) {return [
			'label' => $i['Name'], 'value' => $i['Alias']
		];}, $v['items'])
		,'label' => $v['title'], 'value' => $k
	];}, self::p(null, true)));}

	/**
	 * 2017-04-17
	 * Возвращает массив [Label => Name], например: ["QCardR" => "Bank Card"]
	 * @used-by \Dfe\Robokassa\W\Event::optionTitle()
	 * @param null|string|int|IScope|Store $s [optional]
	 * @return array(string => string)
	 */
	static function map($s = null) {return dfcf(function($s) {return array_column(array_merge(...array_column(
		self::p($s), 'items'
	)), 'Name', 'Label');}, [df_store($s)]);}

	/**
	 * 2017-04-12
	 * 2017-04-16
	 * Результат записит как от $merchantId, так и от $locale,
	 * поэтому эти параметры надо учитывать при расчёте ключа кэширования.
	 * @used-by forCheckout()
	 * @used-by map()
	 * @param null|string|int|IScope|Store $s [optional]
	 * @param bool $canUseDemo [optional]
	 * @return array(string => array(string => string))
	 */
	private static function p($s = null, $canUseDemo = false) {return dfcf(function($merchantId, $locale) {
		/** @var mixed $result */
		/** @var string $url */
		$url = 'https://auth.robokassa.ru/Merchant/WebService/Service.asmx/GetCurrencies';
		/** @var array(string => array(string => string)) $result */
		$result = [];
		foreach (df_xml_parse(df_cache_get_simple(null, 'df_http_get', $url, [
			// 2017-04-15
			// Using the «demo» account allows to receive the list of all Robokassa payment options.
			// I use it only for testing and demonstration.
			'Language' => $locale, 'MerchantLogin' => $merchantId
		]))->{'Groups'}->{'Group'} as $xGroup) {
			/** @var X $xGroup */
			/** @var X[] $xA */
			$xA = $xGroup->attributes();
			/** @var array(array(string => string)) $items */
			$items = [];
			foreach ($xGroup->{'Items'}->{'Currency'} as $xI) {
				/** @var X $xI */
				/** @var X[] $xIA */
				$xIA = $xI->attributes();
				$items[]= [
					'Alias' => df_leaf_s($xIA['Alias'])
					,'Label' => df_leaf_s($xIA['Label'])
					,'MaxValue' => df_leaf_s($xIA['MaxValue'])
					,'MinValue' => df_leaf_s($xIA['MinValue'])
					,'Name' => df_leaf_s($xIA['Name'])
				];
			}
			$result[df_leaf_s($xA['Code'])] = ['title' => df_leaf_s($xA['Description']), 'items' => $items];
		}
		return $result;
	}, [$canUseDemo && df_my() ? 'demo' : dfps(__CLASS__)->merchantID($s), df_locale_ru('ru', 'en')]);}
}