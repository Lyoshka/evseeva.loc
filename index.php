<?php

		set_time_limit(0);		

		require_once dirname(__FILE__) . '/lib/curl_query.php';
		require_once dirname(__FILE__) . '/lib/simple_html_dom.php';
		
		//**********************************************
		//$save_folder = Надо прописать свой каталог для сохранения файлов product--xx.html
		//**********************************************

		$save_folder = '/var/www/html/eliseeva/html/';

		//**********************************************
		
		$arr = array();
		
		$site = 'http://opt.eliseevaolesya.com/look-book/'; 

		echo date('Y-m-d H:i:s') . " -- Start script." . PHP_EOL;
		
		$arr = get_pages ();
		
		for ($i=0;$i<count($arr);$i++)	 {
			
			$count = $i + 1;
			get_product ($arr[$i],$count);
			
		}
		
		echo date('Y-m-d H:i:s') . " -- Download " . count($arr) . " poructs." . PHP_EOL;
		echo date('Y-m-d H:i:s') . " -- Stop script." . PHP_EOL;

		
//Функция определения кол-ва страниц каталога
function get_pages () {
	
	global $site;
	
	$arr = array();
	$all_page = 1000;		//Максимальное кол-во страниц каталога
	
	//Берем ссылки на товары с 1-й страницы каталога
	$html = curl_get($site);
	$dom = str_get_html($html);
	$cats = $dom->find('.home-cat');
	foreach($cats as $cat){
		$a = $cat->find('a',0);
		$arr[] = $a->href;
	}
		
	
	
	for ($i=2;$i<$all_page;$i++) {
		
		$url = 'http://opt.eliseevaolesya.com/look-book/page/' . $i .'/';
		
		$html = curl_get($url);
		
		//Загружает страницу товара
		$dom = str_get_html($html);

		$cat = $dom->find('.home-cat',0);
		
		if ($cat != null) {
			
			//Берем ссылки на страницы товаров 
			$html = curl_get($url);
			$dom = str_get_html($html);
			$cats = $dom->find('.home-cat');
			foreach($cats as $cat){
				$a = $cat->find('a',0);
				$arr[] = $a->href;
				
			}

		} else {
			break;
		}
		
	}
	
	return $arr;
	
}

//Функция скачки товара в HTML		
function get_product ($url,$page=0) {
	
		global $save_folder;
	
		$html = curl_get($url);
		
		//Загружает страницу товара
		$dom = str_get_html($html);

		$article = $dom->find('article',0);
		
		//Берем артикул
		$str = $article->attr['id'];
		
		sscanf($str,'post-%d',$art);
		
		
		$scripts = $dom->find('script');
		
		foreach($scripts as $script){
			if (strpos($script->src,"script.js")) {
				$str = "script[src='" . $script->src . "']";
			}
		}

		$dom->find($str, 0)->outertext = '';
		
		//Ajax запрос
		$html = get_ajax ($art);
		
		//Получили данные из ajax
		$dom2 = str_get_html($html);
		
		//Ищем в 1-й странице div куда будем вставлять данные из ajax
		$dom->find('div[id=order-variables]', 0)->innertext = $dom2;
		
		//Сохраняем HTML
		file_put_contents($save_folder . 'product--' . $page . '.html', $dom);
		
		
}
		

?>