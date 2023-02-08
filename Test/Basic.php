<?php
namespace Dfe\Robokassa\Test;
use Dfe\Robokassa\Api\Options;
use Dfe\Robokassa\Settings as S;
# 2017-04-12
final class Basic extends CaseT {
	/** 2017-04-12 */
	function t01() {print_r(df_dump([$this->s()->password1(), $this->s()->password2()]));}

	/** 2017-04-12 */
	function t02() {print_r(df_json_encode(Options::forCheckout(20000)));}

	/** 2017-04-17 */
	function t03() {print_r(intval(df_my()));}

	/** 2017-08-14 @test */
	function t04() {
		$s = dfps($this); /** @var S $s */
		preg_match($s->v('identification_rules/regex'), 'adasdas111', $matches);
		print_r(df_json_encode($matches));
	}

	/** 2017-08-14 */
	function t05() {print_r(__('String %1 string %1', 'variable'));}
}