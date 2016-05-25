<?php
	$output = $sf_data->getRaw('output');
	$json   = json_encode($output);

	// JSONP
	$callblack = $sf_data->get('callback');

	if ($callback) {
		$json = sprintf('%s(%s);', $callback, $json);
	}

	print($json);
?>