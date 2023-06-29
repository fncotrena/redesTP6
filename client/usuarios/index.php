<?php

	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];

	// Redicciona a login.php
	header('Location: '.$uri.'/usuarios/login.php');
	exit;
?>