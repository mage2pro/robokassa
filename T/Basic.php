<?php
namespace Dfe\Robokassa\T;
use Dfe\Robokassa\Api\Options;
// 2017-04-12
final class Basic extends TestCase {
	/** 2017-04-12 */
	function t01() {echo df_dump([$this->s()->password1(), $this->s()->password2()]);}

	/** @test 2017-04-12 */
	function t02() {echo df_json_encode_pretty(Options::forCheckout(20000));}

	/** 2017-04-17 */
	function t03() {echo intval(df_my());}
}