<?php
namespace Dfe\Robokassa\Api;
use Df\Xml\X;
// 2017-04-12
final class Options {
	/**
	 * 2017-04-12
	 * 2017-04-16
	 * Результат записит как от $merchantId, так и от $locale,
	 * поэтому эти параметры надо учитывать при расчёте ключа кэширования.
	 * @used-by \Dfe\Robokassa\ConfigProvider::options()
	 * @return array(string => array(string => string))
	 */
	static function p() {return dfcf(function($merchantId, $locale) {
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
	}, [df_my() ? 'demo' : dfps(__CLASS__)->merchantID(), df_locale_ru('ru', 'en')]);}
}