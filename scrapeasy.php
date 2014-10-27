<?php
function scrapeasy($contentSource, $selectors, $priorities=array(NULL,"after")) {
	$results = array();
	$content = is_file($contentSource) ? file_get_contents($contentSource) : $contentSource;
	$process = function($priority=NULL) use ($content, $selectors, &$results) {
		foreach($selectors as $k=>$v) {
			@list($key, $prio) = explode(':', $k);
			if($prio != $priority) continue;
			if($prio !== NULL) {
				$content = isset($results[$key]) ? $results[$key] : NULL;
			}
			$fn = $selectors[$k];
			$results[$k] = $fn($content, $results);
		}
	};
	$priorities = empty($priorities) ? array(NULL) : $priorities;
	foreach($priorities as $p) {
		$process($p);
	}
	return $results;
}
