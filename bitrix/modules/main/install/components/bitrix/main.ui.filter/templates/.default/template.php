<?
	use Bitrix\Main\Localization\Loc;
	use Bitrix\Main\UI\Filter\Type;
	use Bitrix\Main\UI\Filter\DateType;

	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	{
		die();
	}

	$this->addExternalCss($this->GetFolder()."/system-styles.css");

	CJSCore::Init(array('ui', 'drag_drop'));

	$isCurrentPreset = is_array($arResult["CURRENT_PRESET"]) && !empty($arResult["CURRENT_PRESET"]);

	if (!empty($arResult["TARGET_VIEW_ID"]))
	{
		$this->SetViewTarget($arResult["TARGET_VIEW_ID"], $arResult["TARGET_VIEW_SORT"]);
		$bodyClass = $APPLICATION->GetPageProperty("BodyClass");
		$APPLICATION->SetPageProperty("BodyClass", ($bodyClass ? $bodyClass." " : "")."headerless-mode");
	}
?>

<!-- Final :: Search -->
<div class="main-ui-filter-search" id="<?=$arParams["FILTER_ID"]?>_search_container">
	<? if ($isCurrentPreset && $arResult["CURRENT_PRESET"]["ID"] !== "default_filter") : ?>
		<span class="main-ui-square main-ui-filter-search-square" data-id="{{ID}}">
		<span class="main-ui-square-item"><?=$arResult["CURRENT_PRESET"]["TITLE"]?></span>
		<span class="main-ui-item-icon main-ui-square-delete"></span>
	</span>
	<? endif; ?>
	<input type="text" tabindex="1" name="FIND" placeholder="<?=$isCurrentPreset ? "Поиск" : "Поиск + Фильтр"?>" class="main-ui-filter-search-filter" id="<?=$arParams["FILTER_ID"]?>_search" autocomplete="off">
	<span class="main-ui-item-icon main-ui-search"></span>
	<span class="main-ui-item-icon main-ui-delete"></span>
</div>


<!-- Final :: NUMBER -->
<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_<?=Type::STRING?>_template">
	<div class="main-ui-control-field">
		<input class="main-ui-control" tabindex="{{TABINDEX}}" name="{{NAME}}" type="text" placeholder="{{PLACEHOLDER}}">
		<div class="main-ui-control-value-delete">
			<span class="main-ui-control-value-delete-item"></span>
		</div>
		<div class="main-ui-item-icon-container">
			<span class="main-ui-item-icon main-ui-delete"></span>
		</div>
	</div>
</script>


<!-- Final :: Square -->
<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_SQUARE_template">
	<span class="main-ui-square" data-id="{{ID}}">
		<span class="main-ui-square-item">{{TITLE}}</span>
		<span class="main-ui-item-icon main-ui-square-delete"></span>
	</span>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_<?=Type::DATE?>_template">
	<div class="main-ui-control-field-group">
		<div class="main-ui-item-icon-container">
			<span class="main-ui-item-icon main-ui-delete"></span>
		</div>
	</div>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_<?=Type::DATE?>_FIELD_template">
	<div class="main-ui-control-field">
		<div class="main-ui-control main-ui-date">
			<span class="main-ui-date-button"></span>
			<input class="main-ui-date-input main-ui-control-input" type="text" tabindex="{{TABINDEX}}" name="{{NAME}}" value="{{VALUE}}" placeholder="{{PLACEHOLDER}}">
		</div>
		<div class="main-ui-control-value-delete">
			<span class="main-ui-control-value-delete-item"></span>
		</div>
	</div>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_FIELD_LINE_template">
	<div class="main-ui-filter-field-line">
		<span class="main-ui-filter-field-line-item"></span>
	</div>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_<?=Type::NUMBER?>_template">
	<div class="main-ui-filter-field-item">
		<input tabindex="{{TABINDEX}}" class="main-ui-filter-field-item-control" name="{{NAME}}" type="text" placeholder="{{PLACEHOLDER}}">
		<div class="main-ui-control-value-delete">
			<span class="main-ui-control-value-delete-item"></span>
		</div>
		<div class="main-ui-item-icon-container">
			<span class="main-ui-item-icon main-ui-delete"></span>
		</div>
	</div>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_<?=Type::MULTI_SELECT?>_template">
	<div class="main-ui-control-field">
		<div class="main-ui-control main-ui-multi-select"
			 data-name="{{NAME}}"
			 data-params="{{PARAMS}}"
			 data-values="{{VALUES}}"
			 data-items="{{ITEMS}}">
			<span class="main-ui-square-container">

			</span>
			<span class="main-ui-square-search">
				<input tabindex="{{TABINDEX}}" placeholder="{{PLACEHOLDER}}" type="text" class="main-ui-square-search-item">
			</span>
			<span class="main-ui-square-search">
					<input type="text" class="main-ui-square-search-item">
				</span>
			<div class="main-ui-control-value-delete">
				<span class="main-ui-control-value-delete-item"></span>
			</div>
		</div>
		<div class="main-ui-item-icon-container">
			<span class="main-ui-item-icon main-ui-delete"></span>
		</div>
	</div>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_<?=Type::SELECT?>_template">
	<div class="main-ui-control-field">
		<div class="main-ui-control main-ui-select"
			 data-name="{{NAME}}"
			 data-params="{{PARAMS}}"
			 data-value="{{VALUE}}"
			 data-items="{{ITEMS}}">
			<span class="main-ui-select-name">{{VALUE_NAME}}</span>
			<span class="main-ui-square-search">
				<input tabindex="{{TABINDEX}}" placeholder="{{PLACEHOLDER}}" type="text" class="main-ui-square-search-item">
			</span>
			<div class="main-ui-control-value-delete">
				<span class="main-ui-control-value-delete-item"></span>
			</div>
		</div>
		<div class="main-ui-item-icon-container">
			<span class="main-ui-item-icon main-ui-delete"></span>
		</div>
	</div>
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_GENERAL_template">
	<div class="main-ui-filter-wrapper">
		<div class="main-ui-filter-inner-container">
			<div class="main-ui-filter-sidebar">
				<div class="main-ui-filter-sidebar-title">
					<h5 class="main-ui-filter-sidebar-title-item">Фильтры</h5>
				</div><!--main-ui-filter-sidebar-->
				<div class="main-ui-filter-sidebar-item-container">
					<? if (is_array($arResult["PRESETS"])) : ?>
						<? foreach ($arResult["PRESETS"] as $key => $preset) : ?>
							<div class="main-ui-filter-sidebar-item<?=$preset["ID"] === $arResult["CURRENT_PRESET"]["ID"] ? " main-ui-filter-current-item" : ""?><?=$preset["ID"] === "default_filter" ? " main-ui-hide" : ""?>"
								 data-id="<?=$preset["ID"]?>">
								<span class="main-ui-item-icon main-ui-filter-icon-grab"></span>
								<span class="main-ui-filter-sidebar-item-text-container">
									<span class="main-ui-filter-sidebar-item-text"><?=$preset["TITLE"]?></span>
									<input type="text" placeholder="<?=Loc::getMessage("MAIN_UI_FILTER__FILTER_NAME_PLACEHOLDER")?>" value="<?=$preset["TITLE"]?>" class="main-ui-filter-sidebar-item-input">
								</span>
								<span class="main-ui-item-icon main-ui-filter-icon-edit"></span>
								<span class="main-ui-item-icon main-ui-delete"></span>
							</div>
						<? endforeach; ?>
					<? endif; ?>
					<div class="main-ui-filter-sidebar-item main-ui-filter-new-filter">
						<div class="main-ui-filter-edit-mask"></div>
						<input class="main-ui-filter-sidebar-edit-control" type="text" placeholder="Название фильтра">
					</div>
				</div><!--main-ui-filter-sidebar-item-container-->
			</div><!--main-ui-filter-sidebar-->
			<div class="main-ui-filter-field-container">
				<div class="main-ui-filter-field-container-list">
					<? if (is_array($arResult["CURRENT_PRESET"]) && !empty($arResult["CURRENT_PRESET"])) : ?>
						<? foreach ($arResult["CURRENT_PRESET"]["FIELDS"] as $key => $field) : ?>
							<? if ($field["TYPE"] === Type::STRING) : ?>
								<div class="main-ui-control-field" data-name="<?=$field["NAME"]?>">
									<input tabindex="<?=$key+2?>" class="main-ui-control" name="<?=$field["NAME"]?>" type="text" placeholder="<?=$field["PLACEHOLDER"]?>">
								</div>
							<? endif; ?>
							<? if ($field["TYPE"] === Type::NUMBER) : ?>
								<div class="main-ui-control-field" data-name="<?=$field["NAME"]?>">
									<input tabindex="<?=$key+2?>" class="main-ui-control" name="<?=$field["NAME"]?>" type="text" placeholder="<?=$field["PLACEHOLDER"]?>">
								</div>
							<? endif; ?>
							<? if ($field["TYPE"] === Type::DATE) : ?>
								<div class="main-ui-control-field-group" data-name="<?=$field["NAME"]?>">
									<div class="main-ui-control-field">
										<div class="main-ui-control main-ui-select"
											 data-name="<?=$field["NAME"]?>"
											 data-params="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["PARAMS"]))?>"
											 data-value="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["SUB_TYPE"]))?>"
											 data-items="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["SUB_TYPES"]))?>">
											<span class="main-ui-item-icon main-ui-search"></span>
											<span class="main-ui-select-name"><?=$field["SUB_TYPE"]["NAME"]?></span>
											<span class="main-ui-square-search">
												<input tabindex="<?=$key+2?>" placeholder="<?=$field["PLACEHOLDER"]?>" type="text" class="main-ui-square-search-item">
											</span>
										</div>
									</div>
									<div class="main-ui-control-field">
										<div class="main-ui-control main-ui-date">
											<span class="main-ui-date-button"></span>
											<input class="main-ui-date-input main-ui-control-input" type="text" tabindex="<?=$key+2?>" name="<?=$field["NAME"]?>_<?=$field["SUB_TYPE"]["VALUE"]?>" value="<?=$field["VALUE"]?>" placeholder="<?=$field["PLACEHOLDER"]?>">
										</div>
									</div>
									<? if ($field["SUB_TYPE"]["VALUE"] === \Bitrix\Main\UI\Filter\DateType::RANGE) : ?>
										<div class="main-ui-filter-field-line">
											<span class="main-ui-filter-field-line-item"></span>
										</div>
										<div class="main-ui-control-field">
											<div class="main-ui-control main-ui-date">
												<span class="main-ui-date-button"></span>
												<input class="main-ui-date-input main-ui-control-input" type="text" tabindex="<?=$key+2?>" name="<?=$field["NAME"]?>_<?=$field["SUB_TYPE"]["VALUE"]?>_TO" value="<?=$field["VALUE"]?>" placeholder="<?=$field["PLACEHOLDER"]?>">
											</div>
										</div>
									<? endif; ?>
								</div>
							<? endif; ?>
							<? if ($field["TYPE"] === Type::SELECT) : ?>
								<div class="main-ui-control-field" data-name="<?=$field["NAME"]?>">
									<div class="main-ui-control main-ui-select"
										 data-params="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["PARAMS"]))?>"
										 data-value="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["VALUE"]))?>"
										 data-items="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["ITEMS"]))?>">
										<span class="main-ui-item-icon main-ui-search"></span>
										<span class="main-ui-select-name"><?=$field["VALUE"]["NAME"]?></span>
										<span class="main-ui-square-search">
											<input tabindex="<?=$key+2?>" placeholder="<?=$field["PLACEHOLDER"]?>" type="text" class="main-ui-square-search-item">
										</span>
										<div class="main-ui-control-value-delete">
											<span class="main-ui-control-value-delete-item"></span>
										</div>
									</div>
									<div class="main-ui-item-icon-container">
										<span class="main-ui-item-icon main-ui-delete"></span>
									</div>
								</div>
							<? endif; ?>
							<? if ($field["TYPE"] === Type::MULTI_SELECT) : ?>
								<div class="main-ui-control-field" data-name="<?=$field["NAME"]?>">
									<div class="main-ui-control main-ui-multi-select"
										 data-name="<?=$field["NAME"]?>"
										 data-params="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["PARAMS"]))?>"
										 data-value="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["VALUE"]))?>"
										 data-items="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field["ITEMS"]))?>">
										<span class="main-ui-square-container">
											<? if (is_array($field["VALUE"]) && !empty($field["VALUE"])) : ?>
												<? foreach ($field["VALUE"] as $fieldkey => $field) : ?>
													<span class="main-ui-square"
														  data-item="<?=\Bitrix\Main\Text\HtmlFilter::encode(\Bitrix\Main\Web\Json::encode($field))?>">
														<span class="main-ui-square-item"><?=$field["NAME"]?></span>
														<span class="main-ui-item-icon main-ui-square-delete"></span>
													</span>
												<? endforeach; ?>
											<? endif; ?>
										</span>
										<span class="main-ui-square-search">
											<input tabindex="<?=$key+2?>" placeholder="<?=$field["PLACEHOLDER"]?>" type="text" class="main-ui-square-search-item">
										</span>
										<div class="main-ui-control-value-delete">
											<span class="main-ui-control-value-delete-item"></span>
										</div>
									</div>
									<div class="main-ui-item-icon-container">
										<span class="main-ui-item-icon main-ui-delete"></span>
									</div>
								</div><!--main-ui-control-field-->
							<? endif; ?>
							<? if ($field["TYPE"] === Type::USER) : ?>
								<div class="main-ui-filter-field-item" data-name="<?=$field["NAME"]?>">
									<input tabindex="<?=$key+2?>" class="main-ui-filter-field-item-control" name="<?=$field["NAME"]?>" type="text" placeholder="<?=$field["PLACEHOLDER"]?>">
								</div>
							<? endif; ?>
							<? if ($field["TYPE"] === Type::ENTITY) : ?>
								<div class="main-ui-filter-field-item" data-name="<?=$field["NAME"]?>">
									<input tabindex="<?=$key+2?>" class="main-ui-filter-field-item-control" name="<?=$field["NAME"]?>" type="text" placeholder="<?=$field["PLACEHOLDER"]?>">
								</div>
							<? endif; ?>
						<? endforeach; ?>
					<? endif; ?>
				</div>

				<div class="main-ui-filter-field-add">
					<span class="main-ui-filter-field-add-item">Добавить поле</span>
				</div><!--main-ui-filter-field-add-->
			</div><!--main-ui-filter-field-container-->
			<div class="main-ui-filter-bottom-controls">
				<div class="main-ui-filter-add-container">
					<span class="main-ui-filter-add-item"><?=Loc::getMessage("MAIN_UI_FILTER__ADD_FILTER")?></span>
					<span class="main-ui-filter-add-edit"></span>
				</div><!--main-ui-filter-add-container-->
				<div class="main-ui-filter-field-button-container">
					<div class="main-ui-filter-field-button-inner">
						<span class="webform-small-button webform-small-button-blue main-ui-filter-field-button main-ui-filter-save">
							<span class="main-ui-filter-field-button-item"><?=Loc::getMessage("MAIN_UI_FILTER__BUTTON_SAVE")?></span>
						</span>
						<span class="webform-small-button webform-small-button-transparent main-ui-filter-field-button main-ui-filter-cancel">
							<span class="main-ui-filter-field-button-item"><?=Loc::getMessage("MAIN_UI_FILTER__BUTTON_CANCEL")?></span>
						</span>
					</div>
				</div>
			</div><!--main-ui-filter-bottom-controls-->
		</div><!--main-ui-filter-inner-container-->
	</div><!--main-ui-filter-wrapper-->
</script>


<script type="text/html" id="<?=$arParams["FILTER_ID"]?>_CLEAN_template">
	<div class="main-ui-filter-wrapper main-ui-filter-edit-item">
		<div class="main-ui-filter-inner-container">
			<div class="main-ui-filter-sidebar">
				<div class="main-ui-filter-sidebar-title">
					<h5 class="main-ui-filter-sidebar-title-item">Фильтры</h5>
				</div><!--main-ui-filter-sidebar-->
				<div class="main-ui-filter-sidebar-item-container">
					<div class="main-ui-filter-sidebar-item main-ui-filter-current-item">
					<span class="main-ui-filter-sidebar-item-text-container">
						<span class="main-ui-filter-sidebar-item-text">Первый фильтр</span>
					</span>
					</div>
					<div class="main-ui-filter-sidebar-item main-ui-filter-edit-current">
						<div class="main-ui-filter-edit-mask"></div>
						<span class="main-ui-item-icon main-ui-filter-icon-grab"></span>
						<span class="main-ui-filter-sidebar-item-text-container">
						<span class="main-ui-filter-sidebar-item-text">Последние сделки</span>
					</span>
						<span class="main-ui-item-icon main-ui-delete"></span>
					</div>
					<div class="main-ui-filter-sidebar-item">
						<span class="main-ui-item-icon main-ui-filter-icon-grab"></span>
						<span class="main-ui-filter-sidebar-item-text-container">
						<span class="main-ui-filter-sidebar-item-text">Просто сделки</span>
					</span>
						<span class="main-ui-item-icon main-ui-filter-icon-edit"></span>
						<span class="main-ui-item-icon main-ui-delete"></span>
					</div>
					<div class="main-ui-filter-sidebar-item">
					<span class="main-ui-filter-sidebar-item-text-container">
						<span class="main-ui-filter-sidebar-item-text">Новые лиды</span>
						<span class="main-ui-item-icon main-ui-filter-icon-pin"></span>
					</span>
					</div>
					<div class="main-ui-filter-sidebar-item main-ui-filter-new-filter">
						<div class="main-ui-filter-edit-mask"></div>
						<input class="main-ui-filter-sidebar-edit-control" type="text" placeholder="Название фильтра">
					</div>
				</div><!--main-ui-filter-sidebar-item-container-->
			</div><!--main-ui-filter-sidebar-->
			<div class="main-ui-filter-field-container">
				<div class="main-ui-control-field">
					<input class="main-ui-control" type="text" placeholder="Вид сделки">
					<div class="main-ui-control-value-delete">
						<span class="main-ui-control-value-delete-item"></span>
					</div>
					<div class="main-ui-item-icon-container">
						<span class="main-ui-item-icon main-ui-delete"></span>
					</div>
				</div><!--main-ui-control-field-->
				<div class="main-ui-control-field">
					<input class="main-ui-control" type="text" placeholder="Дата создания">
					<div class="main-ui-control-value-delete">
						<span class="main-ui-control-value-delete-item"></span>
					</div>
					<div class="main-ui-item-icon-container">
						<span class="main-ui-item-icon main-ui-delete"></span>
					</div>
				</div><!--main-ui-control-field-->

				<div class="main-ui-filter-field-inline-row">
					<div class="main-ui-filter-field-inline-inner">
						<div class="main-ui-control-field main-ui-select">
							<div class="main-ui-control">
								<span class="main-ui-select-name">Диапозон</span>
							</div>
							<div class="main-ui-select-inner">
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Точно</span>
								</div>
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Диапозон</span>
								</div>
							</div><!--main-ui-select-inner-->
						</div><!--main-ui-control-field-->
						<div class="main-ui-control-field">
							<input class="main-ui-control main-ui-number" type="text" placeholder="Число">
							<div class="main-ui-control-value-delete">
								<span class="main-ui-control-value-delete-item"></span>
							</div>
						</div><!--main-ui-control-field-->
						<div class="main-ui-item-icon-container">
							<span class="main-ui-item-icon main-ui-delete"></span>
						</div>
					</div><!--main-ui-filter-field-inline-inner-->
				</div><!--main-ui-filter-field-inline-row-->

				<div class="main-ui-filter-field-inline-row">
					<div class="main-ui-filter-field-inline-inner">
						<div class="main-ui-control-field main-ui-select">
							<div class="main-ui-control">
								<span class="main-ui-select-name">Диапозон</span>
							</div>
							<div class="main-ui-select-inner">
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Точно</span>
								</div>
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Диапозон</span>
								</div>
							</div><!--main-ui-select-inner-->
						</div><!--main-ui-control-field-->
						<div class="main-ui-control-field">
							<input class="main-ui-control main-ui-number" type="text" placeholder="От">
							<div class="main-ui-control-value-delete">
								<span class="main-ui-control-value-delete-item"></span>
							</div>
						</div><!--main-ui-control-field-->
						<div class="main-ui-filter-field-line">
							<span class="main-ui-filter-field-line-item"></span>
						</div>
						<div class="main-ui-control-field">
							<input class="main-ui-control main-ui-number" type="text" placeholder="До">
							<div class="main-ui-control-value-delete">
								<span class="main-ui-control-value-delete-item"></span>
							</div>
						</div><!--main-ui-control-field-->
						<div class="main-ui-item-icon-container">
							<span class="main-ui-item-icon main-ui-delete"></span>
						</div>
					</div><!--main-ui-filter-field-inline-inner-->
				</div><!--main-ui-filter-field-inline-row-->

				<div class="main-ui-filter-field-inline-row">
					<div class="main-ui-filter-field-inline-inner">
						<div class="main-ui-control-field main-ui-select">
							<div class="main-ui-control">
								<span class="main-ui-select-name">Да/Нет</span>
							</div>
							<div class="main-ui-select-inner">
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Да</span>
								</div>
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Нет</span>
								</div>
							</div><!--main-ui-select-inner-->
						</div><!--main-ui-control-field-->
					</div><!--main-ui-filter-field-inline-inner-->
				</div><!--main-ui-filter-field-inline-row-->

				<div class="main-ui-filter-field-inline-row">
					<div class="main-ui-filter-field-inline-inner">
						<div class="main-ui-control-field main-ui-select">
							<div class="main-ui-control">
								<span class="main-ui-select-name">Диапозон</span>
							</div>
							<div class="main-ui-select-inner">
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Точно</span>
								</div>
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Диапозон</span>
								</div>
							</div><!--main-ui-select-inner-->
						</div><!--main-ui-control-field-->
						<div class="main-ui-control-field">
							<span class="main-ui-control main-ui-date">Дата/Время</span>
							<div class="main-ui-control-value-delete">
								<span class="main-ui-control-value-delete-item"></span>
							</div>
						</div><!--main-ui-control-field-->
						<div class="main-ui-filter-field-line">
							<span class="main-ui-filter-field-line-item"></span>
						</div>
						<div class="main-ui-control-field">
							<span class="main-ui-control main-ui-date">Дата/Время</span>
							<div class="main-ui-control-value-delete">
								<span class="main-ui-control-value-delete-item"></span>
							</div>
						</div><!--main-ui-control-field-->
						<div class="main-ui-item-icon-container">
							<span class="main-ui-item-icon main-ui-delete"></span>
						</div>
					</div><!--main-ui-filter-field-inline-inner-->
				</div><!--main-ui-filter-field-inline-row-->

				<div class="main-ui-filter-field-inline-row">
					<div class="main-ui-filter-field-inline-inner">
						<div class="main-ui-control-field main-ui-select">
							<div class="main-ui-control">
								<span class="main-ui-select-name">Диапозон</span>
							</div>
							<div class="main-ui-select-inner">
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Точно</span>
								</div>
								<div class="main-ui-select-inner-item">
									<span class="main-ui-select-inner-item-element">Диапозон</span>
								</div>
							</div><!--main-ui-select-inner-->
						</div><!--main-ui-control-field-->
						<div class="main-ui-control-field">
							<span class="main-ui-control main-ui-date">Дата/Время</span>
						</div><!--main-ui-control-field-->
						<div class="main-ui-item-icon-container">
							<span class="main-ui-item-icon main-ui-delete"></span>
						</div>
					</div><!--main-ui-filter-field-inline-inner-->
				</div><!--main-ui-filter-field-inline-row-->

				<div class="main-ui-control-field">
					<div class="main-ui-control main-ui-select main-ui-search-icon">
						<span class="main-ui-select-name">Селект</span>
						<div class="main-ui-control-value-delete">
							<span class="main-ui-control-value-delete-item"></span>
						</div>
						<div class="main-ui-item-icon-container">
							<span class="main-ui-item-icon main-ui-delete"></span>
						</div>
					</div>
					<div class="main-ui-select-inner">
						<div class="main-ui-select-inner-item">
							<span class="main-ui-select-inner-item-element">Первое значение</span>
						</div>
						<div class="main-ui-select-inner-item">
							<span class="main-ui-select-inner-item-element">Второе значение</span>
						</div>
						<div class="main-ui-select-inner-item">
							<span class="main-ui-select-inner-item-element">Третье значение</span>
						</div>
					</div><!--main-ui-select-inner-->
				</div><!--main-ui-control-field-->

				<div class="main-ui-control-field">
					<div class="main-ui-control main-ui-select main-ui-search-icon">
					<span class="main-ui-square">
						<span class="main-ui-square-item">Random stuff</span>
						<span class="main-ui-item-icon main-ui-square-delete"></span>
					</span>
						<span class="main-ui-square">
						<span class="main-ui-square-item">Random stuff</span>
						<span class="main-ui-item-icon main-ui-square-delete"></span>
					</span>
						<span class="main-ui-square">
						<span class="main-ui-square-item">Random stuff</span>
						<span class="main-ui-item-icon main-ui-square-delete"></span>
					</span>
						<span class="main-ui-square">
						<span class="main-ui-square-item">Random stuff</span>
						<span class="main-ui-item-icon main-ui-square-delete"></span>
					</span>
						<span class="main-ui-square-search">
						<input type="text" class="main-ui-square-search-item">
					</span>
						<div class="main-ui-control-value-delete">
							<span class="main-ui-control-value-delete-item"></span>
						</div>
						<div class="main-ui-item-icon-container">
							<span class="main-ui-item-icon main-ui-delete"></span>
						</div>
					</div>
					<div class="main-ui-select-inner">
						<div class="main-ui-select-inner-item">
							<span class="main-ui-select-inner-label">Первое значение</span>
						</div>
						<div class="main-ui-select-inner-item color1 main-ui-checked">
							<span class="main-ui-select-inner-label">Второе значение</span>
						</div>
						<div class="main-ui-select-inner-item color2 main-ui-checked">
							<span class="main-ui-select-inner-label">Третье значение</span>
						</div>
					</div><!--main-ui-select-inner-->
				</div><!--main-ui-control-field-->

				<div class="main-ui-filter-field-entity">
					<div class="main-ui-control-field">
						<div class="main-ui-control main-ui-entity">
							<span class="main-ui-entity-item">&#43; выбрать привязанную сущность</span>
						</div>
					</div><!--main-ui-control-field-->
				</div><!--main-ui-filter-field-user-->

				<div class="main-ui-filter-field-add">
					<span class="main-ui-filter-field-add-item">Добавить поле</span>
				</div><!--main-ui-filter-field-add-->
			</div><!--main-ui-filter-field-container-->
			<div class="main-ui-filter-bottom-controls">
				<div class="main-ui-filter-add-container">
					<span class="main-ui-filter-add-item">Добавить фильтр</span>
					<span class="main-ui-filter-add-edit"></span>
				</div><!--main-ui-filter-add-container-->
				<div class="main-ui-filter-field-button-container">
					<div class="main-ui-filter-field-button-inner">
				<span class="webform-small-button webform-small-button-blue main-ui-filter-field-button">
					<span class="main-ui-filter-field-button-item">Сохранить</span>
				</span>
						<span class="webform-small-button webform-small-button-transparent main-ui-filter-field-button">
					<span class="main-ui-filter-field-button-item">Отменить</span>
				</span>
					</div>
				</div><!--main-ui-filter-field-button-container-->
			</div><!--main-ui-filter-bottom-controls-->
		</div><!--main-ui-filter-inner-container-->
	</div><!--main-ui-filter-wrapper-->
</script>


<script>
	BX.Main.filterManager.push(
		'<?=$arParams["FILTER_ID"]?>',
		new BX.Main.filter(
			'<?=\Bitrix\Main\Web\Json::encode($arResult)?>',
			{},
			'<?=\Bitrix\Main\Web\Json::encode(Type::getList())?>',
			'<?=\Bitrix\Main\Web\Json::encode(DateType::getList())?>'
		)
	);
</script>

<?

	if (!empty($arResult["TARGET_VIEW_ID"]))
	{
		$this->EndViewTarget();
	}
?>