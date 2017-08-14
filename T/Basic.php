<?php
namespace Dfe\Robokassa\T;
use Dfe\Robokassa\Api\Options;
use \Dfe\Robokassa\Settings as S;
// 2017-04-12
final class Basic extends TestCase {
	/** 2017-04-12 */
	function t01() {echo df_dump([$this->s()->password1(), $this->s()->password2()]);}

	/** 2017-04-12 */
	function t02() {echo df_json_encode(Options::forCheckout(20000));}

	/** 2017-04-17 */
	function t03() {echo intval(df_my());}

	/** @test 2017-08-14 */
	function t04() {
		$s = dfps($this); /** @var S $s */
		preg_match($s->v('identification_rules/regex'), 'adasdas111', $matches);
		echo df_json_encode($matches);
	}

	/** 2017-08-14 */
	function t05() {echo __('String %1 string %1', 'variable');}
}