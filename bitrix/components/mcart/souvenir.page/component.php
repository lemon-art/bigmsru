<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @global CDatabase $DB */
global $DB;
/** @global CUser $USER */
global $USER;
/** @global CMain $APPLICATION */
global $APPLICATION;


if (CModule::IncludeModule("iblock"))
{
	
		
			$id = $arParams["PRODUCT_ID"];
			$res = CIBlockElement::GetByID($id);
			if($ar_res = $res->GetNext())
				
		{	$iblock_id = $ar_res['IBLOCK_ID'];
			
				if (!($iblock_id==$arParams["IBLOCK_ID"]))//если добавляемый элемент - ПОДАРОК, то ничего добавлять не нужно
					{
						
					$SOUVENIRS_IBLOCK_ID = $arParams["IBLOCK_ID"];
					
						$souvenir_id = false;
						$souvenir_section_id = $ar_res["IBLOCK_SECTION_ID"];
						
						$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","DETAIL_PAGE_URL","PROPERTY_with_section", "PROPERTY_with_prod");
						$arFilter = Array("IBLOCK_ID"=>$SOUVENIRS_IBLOCK_ID, "ACTIVE"=>"Y", "=PROPERTY_WITH_PROD"=>$id, "CHECK_PERMISSIONS"=>"N");
						$souvenir_list = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
						if ($ar_souvenir = $souvenir_list->GetNext())
							{$souvenir_id = $ar_souvenir["ID"];
							
							$souvenir_name = $ar_souvenir["NAME"];
							$souvenir_url = $ar_souvenir["DETAIL_PAGE_URL"];
							//fwrite($handle, "souvenir founded: ".$ar_souvenir["NAME"]."[".$ar_souvenir["ID"]."]\n");
							}
						else
						
							{
							
									while ((!$souvenir_id)||($souvenir_section_id))
											{
												$arFilter = Array("IBLOCK_ID"=>$SOUVENIRS_IBLOCK_ID, "ACTIVE"=>"Y", "=PROPERTY_WITH_SECTION"=>$souvenir_section_id);
												$souvenir_list = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
												if ($ar_souvenir = $souvenir_list->GetNext())
													{$souvenir_id = $ar_souvenir["ID"];
													$souvenir_name = $ar_souvenir["NAME"];
													$souvenir_url = $ar_souvenir["DETAIL_PAGE_URL"];
													fwrite($handle, "souvenir founded in section: ".$ar_souvenir["NAME"]."[".$ar_souvenir["ID"]."]\n");
													break;
													}
												
												else
												{
													$res = CIBlockSection::GetByID($souvenir_section_id);
													if($ar_res = $res->GetNext())
														{
														 $souvenir_section_id= $ar_res['IBLOCK_SECTION_ID'];
														if (!$souvenir_section_id)
															break;
														}
												}
											}		
							


							}
						if ($souvenir_id)
						{
							$arResult["SOUVENIR_ID"] = $souvenir_id;
							$arResult["SOUVENIR_NAME"] = $souvenir_name;
							$arResult["SOUVENIR_URL"] = $souvenir_url;
							$this->IncludeComponentTemplate();
						}
					}
				
		}
	

		
	
}
?>