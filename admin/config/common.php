<?php

if (empty($_SESSION['_token'])) {
		$_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(32));
	}

if ($_SERVER['REQUEST_METHOD']==='POST'){
    if(!hash_equals($_SESSION['_token'],$_POST['_token'])){
		echo "invalid CSRF token";
		die();
	} 
}

/**
 * Escapes HTML for output
 *
 */

// function escape($html) {
// 	return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
// }