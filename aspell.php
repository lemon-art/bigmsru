<?php 

require __DIR__ . '/stem.php'; 
echo "<pre>";
print_r(stemming_ru('траба'));



print_r(stemming_ru('Кантроллер'));
print_r(stemming_ru('Кантроллер по кантроллеру кантроллерами'));






//print_r(stemming_ru('Кантроллер для юправления насосом'));

/*$pspell_config = pspell_config_create("ru", null, null, 'utf-8');

pspell_config_dict_dir($pspell_config, "/usr/lib64/aspell-0.60/ru.rws");

$pspell = pspell_new_config($pspell_config);*/

//$checkResult =  pspell_suggest($pspell ,"траба"); 

/*function encode($val){
	return iconv(mb_detect_encoding($val), 'utf-8', $val);// iso8859-5
}

echo "<pre>";
print_r(array_map('encode', $checkResult));*/
