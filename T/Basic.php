<?php
namespace Dfe\Robokassa\T;
// 2017-04-12
final class Basic extends TestCase {
	/** @test 2017-04-12 */
	function t01() {echo df_dump([$this->s()->password1(), $this->s()->password2()]);}
}