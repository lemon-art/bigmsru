<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//if(method_exists($this, 'setFrameMode')) $this->setFrameMode(TRUE);
?>

<li class="auth__name"><a class="auth__link auth__link_dotted" href="<?= $arResult["PROFILE_URL"] ?>"><?=$arResult["USER_NAME"]?></a></li>
<li class="auth__action"><a class="auth__link auth__link_dotted" href="?logout=yes">Выход</a></li>
 
