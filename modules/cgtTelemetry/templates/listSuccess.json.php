<?php
	$output = $sf_data->getRaw('output');
	$json   = json_encode($output);

	print($json);
?>