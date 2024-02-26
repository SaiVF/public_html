<?php

function fecha($val, $type) {

	$mes = array(

		1 => 'enero',

		2 => 'febrero',

		3 => 'marzo',

		4 => 'abril',

		5 => 'mayo',

		6 => 'junio',

		7 => 'julio',

		8 => 'agosto',

		9 => 'septiembre',

		10 => 'octubre',

		11 => 'noviembre',

		12 => 'diciembre'

	);

	$dia = array(

		1 => 'lunes',

		2 => 'martes',

		3 => 'miércoles',

		4 => 'jueves',

		5 => 'viernes',

		6 => 'sábado',

		7 => 'domingo'

	);



	if($type == 'm') {

		return $mes[$val];

	} else if($type == 'd') {

		return $dia[$val];

	}

}



function slug($str, $replace = array(), $delimiter = '-') {

	setlocale(LC_ALL, 'en_US.UTF-8');

	if(!empty($replace)) {

		$str = str_replace((array)$replace, ' ', $str);

	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);

	$clean = strtolower(trim($clean, '-'));

	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;

}



function translate($obj, $var) {

	$locale = App::getLocale();

	return empty($obj->{$var.'_'.$locale}) ? $obj->{$var} : $obj->{$var.'_'.$locale};

}



function isHome()

{

	return Request::is('/');

}



function isRoute($route)

{

	return Request::is($route) ? 'class="strong"' : '';

}



function prettyPrice($price, $currency = 'Gs.')

{

	return $currency.' '.number_format($price, 0, ',', '.');

}


function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
    {
        /*
         * Exceptions in lower case are words you don't want converted
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                } elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
       }//foreach
       return $string;
    }

function getUserIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
