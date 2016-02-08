<?php

function curl_get($url, $referer = 'http://www.google.com') {


$header  = array
(
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
'Accept-Language: en-US,en;q=0.5'
);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:43.0) Gecko/20100101 Firefox/43.0");
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//	curl_setopt($ch, CURLOPT_PROXY, $proxy);
//	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
//	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);		//Использование прокси SOCKS5
	
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;


}

function get_ajax ($id) {


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://opt.eliseevaolesya.com/wp-content/themes/eliseeva%20olesya/cart.php');
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:43.0) Gecko/20100101 Firefox/43.0");
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "id=".$id);
//	curl_setopt($ch, CURLOPT_PROXY, $proxy);
//	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
 
}

?>