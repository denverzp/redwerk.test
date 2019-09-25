<?php

namespace App\Traits;

/**
 * Class stringFunction
 */
trait stringFunction {
	
	/**
	 * remove all text exept limited count simbols
	 * @param $text
	 * @param int $limit
	 * @return string
	 */
	public function limitText($text, $limit = 100) {

		$text = strip_tags( html_entity_decode($text));

		$out = '';

		$tok = strtok($text, ' ');

		while ($tok) {

			$out .= $tok . ' ';

			if (strlen($out) <= $limit) {
				$tok = strtok(' ');
			} else {
				$out .= ' ...';
				break;
			}
		}

		return $out;
	}
}
