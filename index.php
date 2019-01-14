<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "Арматура для отопления, Арматура для радиаторов, Арматура запорная, Арматура измерительная и комплектующие, Арматура предохранительная, Баки мембранные, Бойлеры, Водонагреватели, Гофры, сифоны, трапы, инсталляции, Инструмент и аксессуары для монтажа, Кабель греющий для водопровода, Канализация, Коллекторы, Котлы отопления, Крепёж, Насосы и насосное оборудование, Подводка для воды и газа, Радиаторы отопления секционные, Радиаторы отопления стальные панельные, Система защиты от протечки воды, Теплоизоляция, Теплоноситель, Трубы и фитинги, Фильтры, Фитинги резьбовые, Шкафы коллекторные, Баки топливные, Монтаж напольного отопления, Фитинги ремонтные GEBO, Аксессуары для ванной комнаты, Ванны, Душевые кабины, Полотенцесушители, Унитазы, Смесители, Душевые системы, Душевые стойки, Душевые ограждения, Душевые двери, Шторки на ванну, Мебель для ванной, Инсталляции, Душевая программа");
$APPLICATION->SetPageProperty("description", "Широкий выбор инженерной и бытовой сантехники: водонагреватели, котлы, смесители, унитазы, душевые кабины, трубы и фитинги");
$APPLICATION->SetTitle("\"Большой мастер\" - Интернет-магазин инженерной  и бытовой сантехники");?>

<section class="main-slider">

		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider", 
	array(
		"COMPONENT_TEMPLATE" => "slider",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "self",
			1 => "link",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_STATUS_404" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => "modern",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>




</section>


<section class="demanded-products">

<div class="wrapper_tabs">
	<div id="main_tabs">
		<div class="left_tabs">
		  <ul class="vertical_tabs">
			<li><a href="#tabs-1">Инженерная<br>сантехника</a></li>
			<?/*<li><a href="#tabs-2">Бытовая сантехника</a></li>*/?>
			<li><a href="#tabs-4" style="margin-top: 8px;">Монтаж проектирование</a></li>
			<li><a href="#tabs-3" style="margin-top: 8px;">Распродажа</a></li>
			
		  </ul>
		</div>
		<div class="right_tabs">
		  <div id="tabs-1" class>
				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section.list",
					"sections_new",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => 10,
						"SECTION_ID" => 0,
						"SECTION_CODE" => "",
						"SECTION_USER_FIELDS" => array(    // Свойства разделов
							0 => "UF_SHOWSUBCAT",
							1 => "UF_PICTURE",
							2 => "UF_CUSTOM_URL",
							3 => "UF_ACTIVE",
							4 => "UF_ICON",
							5 => "UF_NO_SECTIONS_SHOW",
						),
						"SHOW_ALL" => "1",
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
						"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
						"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
						"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
						"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?>
		  </div>
		  <?/*
			<div id="tabs-2">
				<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section.list",
						"sections_new",
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => 12,
							"SECTION_ID" => 0,
							"SECTION_CODE" => "",
							"SECTION_USER_FIELDS" => array(    // Свойства разделов
								0 => "UF_SHOWSUBCAT",
								1 => "UF_PICTURE",
								2 => "UF_CUSTOM_URL",
								3 => "UF_ACTIVE",
								4 => "UF_ICON",
								5 => "UF_NO_SECTIONS_SHOW",
							),
							"SHOW_ALL" => "1",
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
							"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
							"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
							"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
							"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);?>
		  </div>
		  */?>
			<div id="tabs-3">
			
				<?
				global $arrFilterNew;
				//$arrFilterNew = Array("!PROPERTY_SHOW_MAIN" => false);
				?>
			
				
		


						<?$APPLICATION->IncludeComponent(
							"custom:catalog.section", 
							"catalog_block", 
							array(
								"COMPONENT_TEMPLATE" => "carusel",
								"IBLOCK_TYPE" => "1c_catalog",
								"IBLOCK_ID" => "10",
								"SECTION_ID" => "",
								"SECTION_CODE" => "",
								"SECTION_USER_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"ELEMENT_SORT_FIELD" => "shows",
								"ELEMENT_SORT_ORDER" => "desc",
								"ELEMENT_SORT_FIELD2" => "id",
								"ELEMENT_SORT_ORDER2" => "desc",
								"FILTER_NAME" => "arrFilterNew",
								"INCLUDE_SUBSECTIONS" => "Y",
								"SHOW_ALL_WO_SECTION" => "Y",
								"HIDE_NOT_AVAILABLE" => "N",
								"PAGE_ELEMENT_COUNT" => "18",
								"LINE_ELEMENT_COUNT" => "3",
								"PROPERTY_CODE" => array(
									0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
									1 => "RAZMER_CHASHI_SHKHVKHG",
									2 => "PRISOEDINITELNYY_RAZMER",
									3 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
									19 => "ZASHCHITA_OT_SUKHOGO_KHODA",
									20 => "VSTRAIVAEMYY",
									21 => "TRUBNOE_PRISOEDINENIE_PRISOEDINITELNYY_RAZMER",
									23 => "DOPUSTIMYY_RAZMER_CHASTITS",
									24 => "NAZNACHENIE_PO_VODE",
									25 => "TIP_NASOSA",
									26 => "MAKSIMALNAYA_TEMPERATURA_S",
									27 => "NAPOR_M",
									28 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
									29 => "TEMPERATURA_RABOCHEY_SREDY_S",
									30 => "NASTROYKA",
									31 => "VID_PODDONA",
									32 => "TOLSHCHINA_MM",
									33 => "ISPOLNENIE_POLOTNA_DVERI",
									34 => "CHASTOTA_GTS",
									35 => "TSVET_ZADNEY_STENKI",
									36 => "ARMIROVANIE",
									37 => "NOMINALNOE_NAPRYAZHENIE_V",
									38 => "DIAPAZON_IZMERENIYA_NAPRYAZHENI_V",
									39 => "MATERIAL_PODDONA",
									40 => "KISLORODNYY_SLOY",
									41 => "NOMINALNYY_TOK_A",
									42 => "INDIKATSIYA_NAPRYAZHENIYA",
									43 => "NALICHIE_KRYSHI",
									44 => "IZLIV_DLYA_VANNY",
									45 => "DIZAYN",
									46 => "GABARITS",
									47 => "TIP_TRUBY",
									48 => "KOLICHESTVO_POLYUSOV",
									50 => "KOLICHESTVO_ZAZHIMOV_KLEMM",
									51 => "RABOCHEE_DAVLENIE_BAR",
									52 => "RASPOLOZHENIE",
									53 => "TERMOSTAT",
									54 => "GLUBINA_MONTAZHA_MM",
									55 => "SPOSOB_PRISOEDINENIYA",
									56 => "DLINA_SM_1",
									57 => "GABARITNYE_RAZMERY_MM",
									58 => "KONSTRUKTSIYA_DVEREY_1",
									59 => "TROPICHESKIY_DUSH_1",
									60 => "KOLICHESTVO_VKHODOV_VVODOV",
									61 => "VNUTRENNIY_BAK",
									62 => "MATERIAL_ZADNEY_STENKI",
									63 => "TEGI",
									64 => "DIAMETR_SM",
									65 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
									66 => "MATERIAL_PROFILYA",
									67 => "NASTENNYE",
									68 => "VSTROENNYY_TEN_KVT",
									69 => "POLOCHKI",
									70 => "TIP_1",
									71 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
									72 => "TIP_IZDELIYA",
									74 => "SREDNIY_NOMINALNYY_SROK_SLUZHBY_CH",
									75 => "PODSOEDINENIE_KONTURA_GVS",
									78 => "MOSHCHNOST_VT_1",
									79 => "RAZMER_MONTAZHNOGO_OTVERSTIYA_POD_MOYKU",
									80 => "PROIZVODITELNOST_M_CHAS",
									81 => "KLASS_ENERGOEFFEKTIVNOSTI",
									82 => "SHIRINA_SHKAFA_SM",
									83 => "POVERKHNOST_NAGREVA_M",
									84 => "TSOKOL",
									85 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
									86 => "TIP_MONTAZHA",
									87 => "ISTOCHNIK_SVETA",
									88 => "KAMERA_SGORANIYA",
									89 => "DIAMETR_DYMOKHODA_MM",
									90 => "PODSOEDINENIE_KONTURA_KHVS",
									91 => "MEZHOSEVOE_RASSTOYANIE_MM",
									93 => "TEPLOOTDACHA_VT",
									94 => "STANDART_PODVODKI_DYUYM",
									95 => "STATUS_NALICHIYA_NA_SKLADE",
									96 => "VRASHCHENIE_IZLIVA",
									97 => "VYDVIZHNOY_IZLIV",
									98 => "KRANBUKSA",
									99 => "DONNYY_KLAPAN",
									100 => "AERATOR",
									103 => "KARTRIDZH",
									105 => "IZOLYATSIYA",
									106 => "UPRAVLENIE",
									107 => "MATERIAL_VNUTRENNEGO_PROVODNIKA",
									108 => "VYSOTA_IZLIVA_SM",
									109 => "MATERIAL_VNESHNEGO_PROVODNIKA",
									110 => "DLINA_IZLIVA_SM",
									111 => "MATERIAL_",
									112 => "NAZNACHENIE_",
									113 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
									114 => "KLASS_ZASHCHITY_IP",
									115 => "REZHIM_RABOTY",
									116 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
									117 => "KOMPLEKTATSIYA_1",
									118 => "GRUPPIROVKA_DLYA_SAYTA",
									119 => "VREMYA_ZARYADKI_AKKUMULYATORA_CH",
									120 => "KOLLEKTSIYA",
									121 => "KOLICHESTVO_AKKUMULYATOROV",
									122 => "OBLAST_PRIMENENIYA",
									123 => "NAPRYAZHENIE_V",
									124 => "OTVERSTIE_DLYA_MONTAZHA",
									125 => "MOSHCHNOST_VT_2",
									126 => "CHASTOTA_GTS_1",
									127 => "OSNASHCHENIE",
									128 => "KLASS_ZASHCHITY",
									129 => "KOMPLEKTY_SMESITELEY",
									130 => "GLUBINA_VSASYVANIYA_M",
									131 => "KOMPLEKTY_SMESITELEY_1",
									132 => "FUNKTSIYA_EKONOMII_RASKHODA",
									133 => "MOSHCHNOST_VT",
									134 => "PROIVODITENOST_L_CH",
									135 => "FITINGI_DLYA",
									136 => "MAKSIMALNYY_NAPOR_M",
									137 => "TIP_MONTAZHA_1",
									138 => "DLINA_KABELYA_M",
									139 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
									140 => "VID_FITINGA_DLYA_TRUB",
									141 => "BUKHTA_M",
									142 => "KOMPLEKTATSIYA",
									143 => "DLINA_SHLANGA_SM",
									144 => "MAKSIMALNOE_DAVLENIE_BAR",
									145 => "RAZMER_VERKHNEGO_DUSHA_SM",
									148 => "VYPUSK_UNITAZA",
									149 => "ISPOLNENIE_SHLANGA",
									150 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
									151 => "RUCHNOY_DUSH",
									152 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
									153 => "SOVMESTIMA_S_PROTOCHNYM_VODONAGREVATELEM",
									154 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
									155 => "SMESITEL_1",
									156 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
									157 => "IZLIV_DLYA_NAPOLNENIYA_VANN_1",
									158 => "MAKS_PROIZVODITELNOST_KPD_",
									159 => "EMKOST_L",
									160 => "PODACHA_GAZA",
									161 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
									162 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
									163 => "TSIRKULYATOR",
									164 => "STEKLO_MM",
									165 => "KONSTRUKTSIYA_DVEREY",
									166 => "SIDENE",
									167 => "ELEKTRONNOE_UPRAVLENIE",
									168 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
									169 => "TROPICHESKIY_DUSH",
									170 => "VENTILYATSIYA",
									171 => "ZERKALO",
									172 => "RADIO",
									173 => "ZADNYAYA_STENKA",
									174 => "ISPOLNENIE_STEKOL",
									175 => "PODSVETKA",
									176 => "PROFIL",
									177 => "SMESITEL",
									178 => "DIAMETR_MM",
									179 => "GIDROMASSAZH",
									181 => "RASPRODAZHA",
									182 => "LIDER_PRODAZH",
									183 => "METOD_KREPLENIYA",
									184 => "STANDART_PODVODKI",
									185 => "TIP_PODVODKI",
									186 => "MEKHANIZM",
									188 => "IZLIV_DLYA_NAPOLNENIYA_VANN",
									189 => "FORMA",
									190 => "DIAMETR_VERKHNEGO_DUSHA",
									191 => "MYLNITSA",
									192 => "POLKA_V_CHASHE",
									193 => "SIDENE_V_KOMPLEKTE",
									194 => "PODVOD_VODY",
									195 => "REZHIM_SLIVA",
									196 => "SISTEMA_ANTIVSPLESK",
									197 => "VYSOTA_CHASHI",
									198 => "OBEM_SMYVNOGO_BACHKA_L",
									199 => "VID_USTANOVKI",
									200 => "SISTEMA_GIDROMASSAZHA",
									201 => "ORIENTATSIYA",
									202 => "UGLOVAYA_KONSTRUKTSIYA",
									203 => "RASPOLOZHENIE_PERELIVA",
									204 => "ANTISKOLZYASHCHEE_POKRYTIE",
									205 => "RUCHKI",
									206 => "NOZHKI",
									207 => "KARKAS",
									208 => "SLIV_PERELIV",
									209 => "PODGOLOVNIK",
									210 => "PODKLYUCHENIE",
									211 => "KOLICHESTVO_SEKTSIY",
									212 => "POVOROTNYY",
									213 => "TOLSHCHINA_STENKI_TRUBY_MM",
									215 => "STRANA_PROIZVODITEL",
									216 => "SHIRINA_SM",
									217 => "DLINA_SM",
									218 => "VYSOTA_SM",
									219 => "GLUBINA_MM",
									220 => "OBYEM_L",
									221 => "MATERIAL",
									222 => "TSVET",
									223 => "STILISTIKA_DIZAYNA",
									225 => "",
								),
								"OFFERS_LIMIT" => "5",
								"TEMPLATE_THEME" => "blue",
								"PRODUCT_SUBSCRIPTION" => "N",
								"SHOW_DISCOUNT_PERCENT" => "N",
								"SHOW_OLD_PRICE" => "N",
								"SHOW_CLOSE_POPUP" => "Y",
								"MESS_BTN_BUY" => "Купить",
								"MESS_BTN_ADD_TO_BASKET" => "В корзину",
								"MESS_BTN_SUBSCRIBE" => "Подписаться",
								"MESS_BTN_DETAIL" => "Подробнее",
								"MESS_NOT_AVAILABLE" => "Нет в наличии",
								"SECTION_URL" => "",
								"DETAIL_URL" => "",
								"SECTION_ID_VARIABLE" => "SECTION_ID",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "36000000",
								"CACHE_GROUPS" => "Y",
								"SET_TITLE" => "N",
								"SET_BROWSER_TITLE" => "N",
								"BROWSER_TITLE" => "-",
								"SET_META_KEYWORDS" => "N",
								"META_KEYWORDS" => "-",
								"SET_META_DESCRIPTION" => "N",
								"META_DESCRIPTION" => "-",
								"ADD_SECTIONS_CHAIN" => "N",
								"SET_STATUS_404" => "Y",
								"CACHE_FILTER" => "N",
								"ACTION_VARIABLE" => "action",
								"PRODUCT_ID_VARIABLE" => "id",
								"PRICE_CODE" => array(
									0 => "Интернет",
								),
								"USE_PRICE_COUNT" => "N",
								"SHOW_PRICE_COUNT" => "1",
								"PRICE_VAT_INCLUDE" => "Y",
								"CONVERT_CURRENCY" => "N",
								"BASKET_URL" => "/basket/",
								"USE_PRODUCT_QUANTITY" => "N",
								"PRODUCT_QUANTITY_VARIABLE" => "",
								"ADD_PROPERTIES_TO_BASKET" => "Y",
								"PRODUCT_PROPS_VARIABLE" => "prop",
								"PARTIAL_PRODUCT_PROPERTIES" => "N",
								"PRODUCT_PROPERTIES" => array(
								),
								"ADD_TO_BASKET_ACTION" => "ADD",
								"DISPLAY_COMPARE" => "Y",
								"PAGER_TEMPLATE" => ".default",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "N",
								"PAGER_TITLE" => "Товары",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"MESS_BTN_COMPARE" => "В сравнение",
								"ADD_PICT_PROP" => "-",
								"LABEL_PROP" => "-",
								"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
								"BACKGROUND_IMAGE" => "-",
								"SEF_MODE" => "N",
								"SET_LAST_MODIFIED" => "N",
								"USE_MAIN_ELEMENT_SECTION" => "N",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"SHOW_404" => "N",
								"MESSAGE_404" => ""
							),
							false
						);?>
			
		  </div>
		  <div id="tabs-4" class="montaz_tab">
				<div class="montaz">
					<h2>Большой мастер.<br>
Профессионализм и высокое качество, доказанные временем</h2>
					<div class="montaz_text">
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/montaz_text.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>

					</div>
				</div>	
				<div class="montaz_anvance">
						<h2>Обратившись в нашу компанию, вы получаете</h2>
						
						<ul>
							<li>
								<img src="/images/m_ico1.jpg">
								<span>Проектирование инженерных систем или грамотный анализ существующего проекта c исправлением всех ошибок и неточностей</span>
							</li>
							<li>
								<img src="/images/m_ico2.jpg">
								<span>Большой выбор инженерной сантехники от ведущих мировых производителей</span>
							</li>
							<li>
								<img src="/images/m_ico3.jpg">
								<span>Компетентную помощь в подборе всего необходимого сантехнического оборудования и комплектующих</span>
							</li>							
							<li>
								<img src="/images/m_ico4.jpg">
								<span>Качественный монтаж систем отопления, водоснабжения и водоотвода с соблюдением всех требований, правил и нормативов</span>
							</li>
						</ul>
						<ul>
							<li>
								<img src="/images/m_ico5.jpg">
								<span>Официальную гарантию на всю продукцию и виды работ</span>
							</li>
							<li>
								<img src="/images/m_ico6.jpg">
								<span>Выезд специалиста для замеров и консультации</span>
							</li>
							<li>
								<img src="/images/m_ico7.jpg">
								<span>Выгодные цены на продукцию и услуги высокого качества</span>
							</li>
						</ul>
					
					
				</div>
				<div class="montaz_video">
					<div class="video_link">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/s5mMOTVl28M" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
					<div class="video_text">
					
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/montaz_video_text.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>
				</div>
				</div>
				
				<div class="montaz_brends">
					<h3>Являемся официальными дистрибьюторами ряда <br>известных мировых торговых марок</h3>
					<ul>
						<li>
							<a href="/proizvoditeli/REHAU/">
								<img src="/images/rehau.png">
							</a>
						</li>
						<li>
							<a href="/proizvoditeli/Grundfos/">
								<img src="/images/grundfos.png">
							</a>
						</li>
						<li>
							<a href="/proizvoditeli/VALTEC/">
								<img src="/images/valtek.png">
							</a>
						</li>
						<li>
							<a href="/proizvoditeli/UPONOR/">
								<img src="/images/uponor.png">
							</a>
						</li>
					</ul>
					
				</div>
				<div class="montaz_footer">
				
					<h3>Задать возникшие вопросы и получить профессиональную консультацию вы можете,<br>
позвонив по телефону либо написать нам на почту.</h3>

					<ul>
						<li class="phone"><a href="tel:+79637667674">+7(963)766-76-74</a></li>
						<li class="email"><a href="mailto:work@bigms.ru">work@bigms.ru</a></li>
					</ul>
				
				</div>
		  </div>
		</div>
	</div>
</div>

</section>





		<section class="advantages">
			<div class="text_main">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"EDIT_TEMPLATE" => "",
					"PATH" => "/include/main_imfo.php"
				)
			);?>
			</div>
                <h2 class="content-h2">Наши преимущества</h2>
                <ul class="advantages__list">
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/free.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Бесплатный<br>пересчет смет</strong>
                    <p class="advantages__text">Мы помогаем оптимизировать затраты клиентов: приводим сметы в порядок, предлагаем технически и экономически обоснованные решения по проектам.</p>
                  </li>
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/partners.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Особые условия<br>для партнеров</strong>
                    <p class="advantages__text">Специальные цены на товары и инструмент в аренду на выгодных условиях для постоянных профессиональных покупателей.</p>
                  </li>
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/eng_santech.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Установка инженерной<br>сантехники</strong>
                    <p class="advantages__text">Компания располагает собственным штатом опытных монтажников. Мы устанавливаем инженерную сантехнику с гарантией до 2 лет.</p>
                  </li>
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/help.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Помощь<br>с гарантией</strong>
                    <p class="advantages__text">Мы помогаем покупателям решать гарантийные вопросы с сервисными центрами. Берем все связанные с этим заботы на себя.</p>
                  </li>
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/brands.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Проверенные<br>бренды</strong>
                    <p class="advantages__text">«Большой мастер» работает только с сертифицированной брендовой сантехникой. Никакого азиатского ширпотреба и подделок, никаких полукустарных решений в стиле «дешево и сердито» на один день</p>
                  </li>
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/gifts.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Акции<br>и подарки</strong>
                    <p class="advantages__text">У нас действуют специальные условия на акционные товары. Магазин организует бесплатную доставку или дарит подарок при покупке.</p>
                  </li>
                  <li class="advantages__item">
                    <div class="advantages__img-wrap">
                      <img src="/images/icons/return.png" alt="" class="advantages__img">
                    </div>
                    <strong class="advantages__title">Возврат товара<br>в течение 2 месяцев</strong>
                    <p class="advantages__text">Если товар не подошел, покупатель может отдать его назад в течение 60 суток со дня приобретения, и мы вернем ему всю сумму.</p>
                  </li>
                </ul>
              </section>


<?/*
 <div data-retailrocket-markup-block="58da518b65bf1907bc2310ab" ></div>
 */?>






<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>