<?php
function getAttr($array) {
	$result = [];
	$keys = array_keys($array); // ['attr', 'prop']
	foreach($keys as $key) {
		//'attr'
		//'prop'
		foreach($array[$key] as $k => $v) {
			$result[] = $k . ($v === true ? '' : "='" . $v . "'");
		}
	}
	return implode(' ', $result);
}