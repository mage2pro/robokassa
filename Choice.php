<?php
namespace Dfe\Robokassa;
use Dfe\Robokassa\W\Event;
use Magento\Framework\Phrase;
// 2017-04-17
/** @method Event|string|null responseF(...$k) */
final class Choice extends \Df\Payment\Choice {
	/**
	 * 2017-04-17
	 * @override
	 * @see \Df\Payment\Choice::title()
	 * @used-by \Df\Payment\Observer\DataProvider\SearchResult::execute()
	 * @return Phrase|string|null
	 */
	function title() {return dfc($this, function() {return /** @var Event $ev */
		($ev = $this->responseF()) ? $ev->optionTitle($this->m()->store()) :  null
	;});}
}