<?php
namespace Dfe\Robokassa\Api;
use Df\Xml\X;
use Magento\Framework\App\ScopeInterface as IScope;
use Magento\Store\Api\Data\StoreInterface as IStore;
use Magento\Store\Model\Store;
# 2017-04-12
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
	 * @used-by \Dfe\Robokassa\ConfigProvider::options()
	 * @return array(string => mixed)
	 */
	static function forCheckout(float $a):array {return array_values(array_filter(df_map_k(
		function($k, array $g) use($a) {return
			!($items = array_values(array_filter($g[self::$ITEMS], function(array $i) use($a) {return
				(!($max = dfa($i, self::$MAX)) || $a <= $max)
				&& (!($min = dfa($i, self::$MIN)) || $a >= $min)
			;}))) ? null : [
				'children' => df_map(function(array $i) {return [
					'label' => $i[self::$LABEL], 'value' => $i[self::$ID_UNIVERSAL]
				];}, $items)
				,'label' => $g[self::$G_TITLE], 'value' => $k
			]
		;}, self::p(null, true)
	)));}

	/**
	 * 2017-04-17 Возвращает массив [Label => Name], например: ["QCardR" => "Bank Card"]
	 * @used-by \Dfe\Robokassa\W\Event::optionTitle()
	 * @param null|string|int|IScope|Store $s [optional]
	 * @return array(string => string)
	 */
	static function map($s = null):array {return dfcf(function(IStore $s):array {return array_column(array_merge(
		...array_column(self::p($s), self::$ITEMS)
	), self::$LABEL, self::$ID_SPECIFIC);}, [df_store($s)]);}

	/**
	 * 2017-04-17
	 * 1) Опция «Единая Касса» (Wallet One) размещена сразу в 2 разделах:
	 * 1.1) в правильный: «Электронным кошельком»
	 * 1.2) в неправильный: «Через интернет-банк»
	 * Исключаем её из раздела «Через интернет-банк».
	 * 2) У ФлексБанка отозвана лицензия ещё 2016-12-19, но Робокасса почему-то всё равно эту опцию предлагает.
	 * 3) У ВестИнтерБанка отозвана лицензия ещё 2016-10-27, но Робокасса почему-то всё равно эту опцию предлагает.
	 * @used-by self::p()
	 */
	private static function excluded(string $g, string $i):bool {return
		('Bank' === $g && 'W1' === $i) || in_array($i, ['HandyBankFB', 'HandyBankVIB'])
	;}

	/**
	 * 2017-04-12
	 * 2017-04-16
	 * Результат записит как от $merchantId, так и от $locale,
	 * поэтому эти параметры надо учитывать при расчёте ключа кэширования.
	 * 2017-04-17
	 * https://auth.robokassa.ru/Merchant/WebService/Service.asmx/GetCurrencies?MerchantLogin=2016-10-18-2&Language=ru
	 * https://auth.robokassa.ru/Merchant/WebService/Service.asmx/GetCurrencies?MerchantLogin=demo&Language=ru
	 * @used-by self::forCheckout()
	 * @used-by self::map()
	 * @param null|string|int|IScope|Store $s [optional]
	 * @param bool $canUseDemo [optional]
	 * @return array(string => array(string => string))
	 */
	private static function p($s = null, $canUseDemo = false) {return dfcf(function($merchantId, $locale) {
		$url = 'https://auth.robokassa.ru/Merchant/WebService/Service.asmx/GetCurrencies'; /** @var string $url */
		$r = []; /** @var array(string => array(string => string)) $r */
		foreach (df_xml_parse(df_cache_get_simple('', 'df_http_get', [], $url, [
			# 2017-04-15
			# Using the «demo» account allows to receive the list of all Robokassa payment options.
			# I use it only for testing and demonstration.
			'Language' => $locale, 'MerchantLogin' => $merchantId
		]))->{'Groups'}->{'Group'} as $xGroup) { /** @var X $xGroup */
			$xA = $xGroup->attributes(); /** @var X[] $xA */
			$items = []; /** @var array(array(string => string)) $items */
			$gCode = df_leaf_s($xA['Code']); /** @var string $gCode */
			foreach ($xGroup->{'Items'}->{'Currency'} as $xI) {/** @var X $xI */
				$xIA = $xI->attributes(); /** @var X[] $xIA */
				if (!self::excluded($gCode, $alias = df_leaf_s($xIA['Alias']))) {/** @var string $alias */
					$items[]= [
						self::$ID_UNIVERSAL => $alias
						,self::$ID_SPECIFIC => df_leaf_s($xIA['Label'])
						,self::$MAX => df_leaf_s($xIA['MaxValue'])
						,self::$MIN => df_leaf_s($xIA['MinValue'])
						,self::$LABEL => df_leaf_s($xIA['Name'])
					];
				}
			}
			if ($items) {
				$r[$gCode] = [self::$G_TITLE => df_leaf_s($xA['Description']), self::$ITEMS => $items];
			}
		}
		# 2017-04-18
		# Опция «QIWI Кошелёк» размещена сразу в 2 разделах: «Электронным кошельком» и «В терминале»,
		# причём в разделе «В терминале» она является единственной опцией,
		# а опция «Элекснет», которую разумно было бы поместить в раздел «В терминале»,
		# размещена в разделе «Электронным кошельком».
		# Решил сделать так:
		# 1) Исключить опцию «QIWI Кошелёк» из раздела «В терминале».
		# 2) Объединить разделы «Электронным кошельком» и «В терминале» в единый раздел
		# «Электронным кошельком / В терминале».
		/** @var array(string => string|array)|null $gTerminals */
		$gTerminals = dfa($r, 'Terminals');
		/** @var array(string => string|array)|null $gWallet */
		$gWallet = dfa($r, 'EMoney');
		if ($gTerminals && $gWallet) {
			$r['EMoney'] = [
				self::$G_TITLE => "{$gWallet[self::$G_TITLE]} / {$gTerminals[self::$G_TITLE]}"
				# 2017-04-18 Таким алгоритмом мы удаляем дубликаты.
				,self::$ITEMS => array_values(df_map_kr(function($k, $v) {return [
					$v[self::$ID_UNIVERSAL],$v
				];}, array_merge($gWallet[self::$ITEMS], $gTerminals[self::$ITEMS])))
			];
			unset($r['Terminals']);
		}
		/** @var array(string => int) $w */
		if ($gMobile = dfa($r, 'Mobile')) {/** @var array(string => string|array)|null $gMobile */
			# 2017-04-18 Порядок следования мобильных операторов.
			$w = array_flip(['PhoneMTS', 'PhoneBeeline', 'PhoneMegafon', 'PhoneTele2', 'PhoneTatTelecom']);
			$r['Mobile'] = [self::$ITEMS => df_sort($gMobile[self::$ITEMS], function($a, $b) use($w) {
				return dfa($w, $a[self::$ID_UNIVERSAL], -1) - dfa($w, $b[self::$ID_UNIVERSAL], -1)
			;})] + $gMobile;
		}
		# 2017-04-18 Порядок следования разделов.
		$w = array_flip(['BankCard', 'Bank', 'EMoney', 'Mobile', 'Other']); /** @var array(string => int) $w */
		return df_ksort($r, function($a, $b) use($w) {return dfa($w, $a, -1) - dfa($w, $b, -1);});
	}, [$canUseDemo && df_my() ? 'demo' : dfps(__CLASS__)->merchantID($s), df_lang_ru_en()]);}

	/**
	 * 2017-04-17 Зависит от локали. Для банковской карты: «Банковская карта», «Bank card».
	 * @used-by self::forCheckout()
	 * @used-by self::p()
	 * @var string
	 */
	private static $G_TITLE = 'title';

	/**
	 * 2017-04-17 Зависит от магазина. Например, для банковской карты может быть: «QCardR», «BANKOCEAN3R».
	 * @used-by self::map()
	 * @used-by self::p()
	 * @var string
	 */
	private static $ID_SPECIFIC = 'id_specific';

	/**
	 * 2017-04-17 Не зависит от магазина. Для банковской карты: «BankCard».
	 * @used-by self::forCheckout()
	 * @used-by self::p()
	 * @var string
	 */
	private static $ID_UNIVERSAL = 'id_universal';

	/**
	 * 2017-04-17
	 * @used-by self::forCheckout()
	 * @used-by self::map()
	 * @used-by self::p()
	 * @var string
	 */
	private static $ITEMS = 'items';

	/**
	 * 2017-04-17
	 * @used-by self::forCheckout()
	 * @used-by self::p()
	 * @var string
	 */
	private static $MAX = 'max';
	/**
	 * 2017-04-17
	 * @used-by self::forCheckout()
	 * @used-by self::p()
	 * @var string
	 */
	private static $MIN = 'min';

	/**
	 * 2017-04-17
	 * @used-by self::forCheckout()
	 * @used-by self::map()
	 * @used-by self::p()
	 * @var string
	 */
	private static $LABEL = 'label';
}