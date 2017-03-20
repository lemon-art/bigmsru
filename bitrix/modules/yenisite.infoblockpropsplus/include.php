<?


class CYenisiteInfoblockpropsplus
{
    const tblGroups = 'yen_ipep_groups';
    const tblPropsToGroups = 'yen_ipep_props_to_groups';
    const tblPropsComments = 'yen_ipep_props_comments';
    const cacheTime = 2764800;
    const cacheID = 'yeni_ipep_GetList';
    const cacheDir = '/yeni_ipep_GetList';
    const moduldeID = 'yenisite.infoblockpropsplus';

    static function OnEpilog()
    {
        $Select_iblock = COption::GetOptionString(self::moduldeID, 'select_iblock', '');
        $arIblock_not_work = unserialize($Select_iblock);

        if (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true) {
            return;
        }
        if ($GLOBALS['APPLICATION']->GetCurPage() != '/bitrix/admin/iblock_edit.php' &&
            $GLOBALS['APPLICATION']->GetCurPage() != '/bitrix/admin/cat_section_edit.php' &&
            $GLOBALS['APPLICATION']->GetCurPage() != '/bitrix/admin/iblock_section_edit.php'
        ) {
            return;
        }

        if ($GLOBALS['APPLICATION']->GetCurPage() == '/bitrix/admin/cat_section_edit.php'
            | $GLOBALS['APPLICATION']->GetCurPage() == '/bitrix/admin/iblock_section_edit.php'
            && isset($arIblock_not_work[$_REQUEST['IBLOCK_ID']])){
            return;
        }

        if ($GLOBALS['APPLICATION']->GetCurPage() == '/bitrix/admin/iblock_edit.php'
            && isset($arIblock_not_work[$_REQUEST['ID']])){
            return;
        }

        CJSCore::RegisterExt(
            'jquery_ui',
            array(
                'js' => '/bitrix/js/yenisite.infoblockpropsplus/jquery-ui.min.js',
                'rel' => array('jquery'),
            )
        );

        CJSCore::RegisterExt(
            'jquery_scrollto',
            array(
                'js' => '/bitrix/js/yenisite.infoblockpropsplus/jquery-scrollto.min.js',
                'rel' => array('jquery'),
            )
        );

        CJSCore::RegisterExt(
            'yeni_ipep',
            array(
                'js' => '/bitrix/js/' . self::moduldeID . '/ipep.js',
                'css' => '/bitrix/js/' . self::moduldeID . '/styles.css',
                'lang' => '/bitrix/modules/' . self::moduldeID . '/lang/' . LANGUAGE_ID . '/js.php',
                'rel' => array('jquery_ui', 'jquery_scrollto'),
            )
        );

        CJSCore::Init('yeni_ipep');

        if ($GLOBALS['APPLICATION']->GetCurPage() == '/bitrix/admin/iblock_edit.php') {
            $arParams = array('IBLOCK_ID' => $_REQUEST['ID'], 'SECTION_ID' => -1);
            $init_function = 'yeni_ipep.init()';
        } elseif ($GLOBALS['APPLICATION']->GetCurPage() == '/bitrix/admin/cat_section_edit.php'
            || $GLOBALS['APPLICATION']->GetCurPage() == '/bitrix/admin/iblock_section_edit.php'
        ) {
            $arParams = array(
                'IBLOCK_ID' => $_REQUEST['IBLOCK_ID'],
                'SECTION_ID' => $_REQUEST['ID']
            );
            $init_function = 'yeni_ipep.init_cat_section()';
        }


        $initArray = self::GetInitArray($arParams);

        $GLOBALS['APPLICATION']->AddHeadString('<script type="text/javascript">$(function(){
			yeni_ipep.cur_iblock_id = ' . $arParams['IBLOCK_ID'] . '; 
			yeni_ipep.cur_section_id = ' . $arParams['SECTION_ID'] . '; 
			yeni_ipep.props_to_groups = ' . CUtil::PhpToJSObject($initArray['PROPS_TO_GROUPS']) . '; 
			yeni_ipep.props_comments = ' . CUtil::PhpToJSObject($initArray['PROPS_COMMENTS']) . ';
            setTimeout(' . $init_function . ', 10);});</script>');

        IncludeModuleLangFile(__FILE__);
    }

    static function InitJQueryUI()
    {
        CJSCore::RegisterExt(
            'jquery_ui',
            array(
                'js' => '/bitrix/js/yenisite.infoblockpropsplus/jquery-ui.min.js',
                'rel' => array('jquery'),
            )
        );
        CJSCore::Init('jquery_ui');
    }

    static function GetInitArray($arFilter)
    {
        global $DB;
        if (!CModule::IncludeModule('iblock'))
            return;
        $cache_ID = self::cacheID . '_' . serialize($arFilter);

        $obCache = new CPHPCache();
        if ($obCache->InitCache(self::cacheTime, $cache_ID, self::cacheDir)) {
            $vars = $obCache->GetVars();
            $arResult = $vars['DATA'];
        } elseif ($obCache->StartDataCache()) {
            if(defined("BX_COMP_MANAGED_CACHE")) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache(self::cacheDir);
            }

            $arPropsComments = array();
            $arPropsToGroups = array();
            $arSections = array();
            $arSortableProps = array();

            // $arFilter['SECTION_ID'] > 0 - get groups for concrete section
            // $arFilter['SECTION_ID'] = 0 - get only common groups
            // $arFilter['SECTION_ID'] < 0 - get all group
            if (intval($arFilter['SECTION_ID']) > 0) {
                $arSections[] = 0;
                if (COption::GetOptionString(self::moduldeID, 'group_from_parent_sections', 'N') == 'Y') {
                    $nav = CIBlockSection::GetNavChain($arFilter['IBLOCK_ID'], $arFilter['SECTION_ID'], array('ID'));
                    while ($ar_nav = $nav->GetNext()) {
                        $arSections[] = $ar_nav['ID'];
                    }
                } else {
                    $arSections[] = $arFilter['SECTION_ID'];
                }
            } elseif (intval($arFilter['SECTION_ID']) == 0)
                $arSections[] = intval($arFilter['SECTION_ID']);

            $rsList = $DB->Query(
                'SELECT
					g.IBLOCK_ID,
					g.ID as GROUP_ID,
					g.NAME AS GROUP_NAME,
					g.MAIN_GROUP AS MAIN_GROUP,
					g.SORT as GROUP_SORT,
					g.SECTION_ID as GROUP_SECTION_ID,
					pg.PROPERTY_ID,
					bp.SORT
				FROM
					' . self::tblGroups . ' g
				LEFT JOIN ' . self::tblPropsToGroups . ' pg ON pg.GROUP_ID = g.ID
				LEFT JOIN b_iblock_property bp ON bp.ID = pg.PROPERTY_ID'
                . ' WHERE 1=1'
                . (intval($arFilter['IBLOCK_ID']) > 0 ? ' AND g.IBLOCK_ID = ' . intval($arFilter['IBLOCK_ID']) : '')
               // . (intval($arFilter['SECTION_ID']) > 0 ? ' AND (g.SECTION_ID = ' . intval($arFilter['SECTION_ID']).' OR g.SECTION_ID = 0 )' : '')
                . (count($arSections) > 0 ? ' AND g.SECTION_ID IN(' . implode(',', $arSections) . ')' : '')
                . ' ORDER BY
					g.SORT ASC, bp.sort ASC',
                true
            );
            while ($arItem = $rsList->Fetch()) {
                $arPropsToGroups[$arItem['GROUP_ID'] . '_' . $arItem['GROUP_SORT']][] = $arItem;
            }

            // add comment to array
            $arProperties = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("ACTIVE" => "Y", "IBLOCK_ID" => intval($arFilter['IBLOCK_ID'])));
            while ($prop = $arProperties->GetNext()) {
                $arPropsComments[$prop['ID']] = html_entity_decode($prop['HINT']);
                foreach($arPropsToGroups as $key => &$arProps){
                    if (!empty($arProps[$key])){
                        $arProps[$key]['SORT'] = $prop['SORT'];
                    }
                }
            }

            /*
            foreach($arPropsToGroups as $key => $arProps){
                foreach($arProps as $keyProp => $prop) {
                    if(empty($keyProp)) continue;
                    if (!isset($arSortableProps[$key][strval($prop['SORT'])])) {
                        $arSortableProps[$key][strval($prop['SORT'])] = $keyProp;
                    } else {
                        $index = 1;
                        while (isset($arSortableProps[$key][strval($prop['SORT'])])) {
                            $prop['SORT'] += $index;
                        }
                        $arSortableProps[$key][strval($prop['SORT'])] = $keyProp;
                    }
                }
            }
            unset($arProps,$prop);

            foreach($arSortableProps as $key => &$adProps){
                ksort($adProps);
                $adProps = array_flip($adProps);
            }

            foreach($arPropsToGroups as $key => $arProps){
                if (!empty($arSortableProps[$key])){
                    foreach($arProps as $keyProp => $prop){
                        $arSortableProps[$key][strval($keyProp)] = $prop;
                    }
                }else{
                    $arSortableProps[$key] = $arProps;
                }
            }

            $arPropsToGroups = $arSortableProps;*/

            // old
            // $rsList = $DB->Query('SELECT * FROM ' . self::tblPropsComments, true);
            // while ($arItem = $rsList->Fetch()) {
            // $arPropsComments[$arItem['PROPERTY_ID']] = $arItem['COMMENT'];
            // }

            $arResult = array('PROPS_TO_GROUPS' => $arPropsToGroups, 'PROPS_COMMENTS' => $arPropsComments);

            if(defined("BX_COMP_MANAGED_CACHE")) {
                $CACHE_MANAGER->RegisterTag(self::cacheID);
                $CACHE_MANAGER->EndTagCache();
            }

            $obCache->EndDataCache(array('DATA' => $arResult));
        }

        return $arResult;

    }

    static function OnIBlockDelete($IBLOCK_ID)
    {
        $IBLOCK_ID = intval($IBLOCK_ID);
        if ($IBLOCK_ID <= 0) {
            return false;
        }

        global $DB;
        $queryStrings = array();
        $queryStrings[] = 'DELETE FROM ' . self::tblGroups . ' WHERE IBLOCK_ID = ' . $IBLOCK_ID;
        $queryStrings[] = 'DELETE FROM ' . self::tblPropsComments . ' WHERE IBLOCK_ID = ' . $IBLOCK_ID;
        $queryStrings[] = 'DELETE FROM ' . self::tblPropsToGroups . ' WHERE IBLOCK_ID = ' . $IBLOCK_ID;

        $DB->Query(join(';', $queryStrings), true);
    }

    static function OnIBlockPropertyDelete($PROPERTY_ID)
    {
        $PROPERTY_ID = intval($PROPERTY_ID);
        if ($PROPERTY_ID <= 0) {
            return false;
        }

        global $DB;
        $queryStrings = array();
        $queryStrings[] = 'DELETE FROM ' . self::tblPropsComments . ' WHERE PROPERTY_ID = ' . $PROPERTY_ID;
        $queryStrings[] = 'DELETE FROM ' . self::tblPropsToGroups . ' WHERE PROPERTY_ID = ' . $PROPERTY_ID;

        $DB->Query(join(';', $queryStrings), true);
    }

    static function ConvertText($text)
    {
        if (defined('BX_UTF')) {
            return $text;
        }

        return $GLOBALS['APPLICATION']->ConvertCharset($text, 'UTF-8', 'WINDOWS-1251');
    }

    static function ProcessAjax($arParams)
    {
        $arResult = array('IS_ERROR' => false);
        switch ($arParams['action']) {
            case 'add_group':
                $arParams['group_name'] = stripslashes($arParams['group_name']);
                $arParams['group_props'] = explode(',', $arParams['group_props']);
                $arParams['group_section'] = isset($arParams['group_section']) ? $arParams['group_section'] : false;

                // $arParams['group_id'] > 0 - group is already exist
                // $arParams['group_id'] = 0 - new group
                // $arParams['group_id'] < 0 - for props without group
                if (intval($arParams['group_id']) == 0 && intval($arParams['iblock_id']) > 0 && strlen($arParams['group_name']) > 0) {
                    $arParams['group_id'] = self::AddGroup($arParams['iblock_id'], $arParams['group_name'], $arParams['group_sorting'], $arParams['group_section'], $arParams['in_section_edit'], $arParams['main_group']);
                    if ($arParams['group_id'] == false) {
                        $arResult['IS_ERROR'] = true;
                        $arResult['ERROR_CODE'] = 'CANT_ADD_GROUP';
                    } else {
                        $arResult['new_group_id'] = $arParams['group_id'];
                    }
                } else {
                    self::UpdateGroup($arParams['group_id'], $arParams['group_name'], $arParams['group_sorting'], $arParams['iblock_id'], $arParams['group_section'], $arParams['in_section_edit'], $arParams['main_group']);
                }

                if (intval($arParams['group_id']) != 0) {
                    self::AddPropsToGroup($arParams['group_props'], $arParams['iblock_id'], $arParams['group_id']);
                }
				// comment this? because we can't sort properties in section page
                // if($arParams['group_id'] > 0){
                    // self::updateIpepGroup($arParams['iblock_id'], json_decode($arParams['props_sort']));
                // }
                break;

            case 'remove_group':
                self::RemoveGroup($arParams['group_id']);
                break;

            case 'edit_prop_comment':
                $arParams['comment'] = urldecode(stripslashes($arParams['comment']));
                self::EditPropComment($arParams['prop_id'], $arParams['iblock_id'], $arParams['comment']);

                if (isset($arParams['prop_info'])) {
                    $arEncodedProp = unserialize(base64_decode($arParams['prop_info']));
                    if ($arEncodedProp) {
                        $arEncodedProp['HINT'] = self::ConvertText($arParams['comment']);
                        $arResult['prop_info'] = base64_encode(serialize($arEncodedProp));
                    }
                }

                break;

            default:
                $arResult['IS_ERROR'] = true;
                $arResult['ERROR_CODE'] = 'UNKNOWN_ACTION';
        }

        if ($arResult['IS_ERROR'] != true) {
			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->ClearByTag(self::cacheID);
				unset($CACHE_MANAGER);
			}else{
				$obCache = new CPHPCache();
				$obCache->CleanDir(self::cacheDir);
			}
        }

        return $arResult;
    }

    static function EditPropComment($prop_id, $iblock_id, $comment)
    {
        if (!CModule::IncludeModule('iblock'))
            return;

        $prop_id = intval($prop_id);
        $iblock_id = intval($iblock_id);

        if ($prop_id <= 0 || $iblock_id <= 0) {
            return false;
        }

        $ibp = new CIBlockProperty;
        if (!$ibp->Update($prop_id, array('HINT' => self::ConvertText($comment))))
            return $ibp->LAST_ERROR;
        unset($ibp);
        // old
        //return $DB->Query('INSERT INTO ' . self::tblPropsComments . ' (`PROPERTY_ID`, `IBLOCK_ID`, `COMMENT`) VALUES(' . $prop_id . ', ' . $iblock_id . ', "' . $DB->ForSql(self::ConvertText($comment)) . '") ON DUPLICATE KEY UPDATE `COMMENT` = "' . $DB->ForSql(self::ConvertText(($comment))) . '"', true);
    }

    static function RemoveGroup($group_id)
    {
        global $DB;
        $group_id = intval($group_id);

        if ($group_id <= 0) {
            return false;
        }

        $DB->Query('DELETE FROM ' . self::tblGroups . ' WHERE `ID` = ' . $group_id, true);
        $DB->Query('DELETE FROM ' . self::tblPropsToGroups . ' WHERE `GROUP_ID` = ' . $group_id, true);
    }

    static function UpdateGroup($group_id, $group_name, $group_sorting, $iblock_id, $section_id, $in_section_edit = 'n', $main_group)
    {
        global $DB;
        $iblock_id = intval($iblock_id);

        if (strlen($group_name) == 0 || $iblock_id <= 0) {
            return false;
        }
        if (is_numeric($section_id))
            $update_section_id = ', `SECTION_ID` = ' . intval($section_id);
        else
            $update_section_id = '';

        $sortUpdate = ', `SORT` = ' . intval($group_sorting);
		
		if ( $main_group ){
			$MAIN_GROUP = ', `MAIN_GROUP` = ' . $main_group;
		}
		else {
			$MAIN_GROUP = '';
		}

        if ($DB->Query('update ' . self::tblGroups . ' SET `NAME` = "' . $DB->ForSql(self::ConvertText($group_name)) . '"' . $MAIN_GROUP . $sortUpdate . $update_section_id . ' WHERE `ID` = ' . $group_id, true) == false) {
            return self::AddGroup($iblock_id, $group_name, $group_sorting, $section_id);

        }
    }

    static function AddGroup($iblock_id, $group_name, $group_sorting, $section_id = 0, $in_section_edit = 'n', $main_group = "")
    {
        global $DB;

        $iblock_id = intval($iblock_id);
        $group_sorting = intval($group_sorting);
        $section_id = intval($section_id);

        if (strlen($group_name) == 0 || $iblock_id <= 0) {
            return false;
        }

        $res = $DB->Query('select ID from ' . self::tblGroups . ' where name = "' . $DB->ForSql(self::ConvertText($group_name)) . '" and iblock_id = ' . $iblock_id)->Fetch();

        if(empty($res['ID'])) {
            if ($DB->Query('insert into ' . self::tblGroups . ' ( `NAME`, `IBLOCK_ID`, `MAIN_GROUP`, `SORT`, `SECTION_ID`) values ( "' . $DB->ForSql(self::ConvertText($group_name)) . '",' . $iblock_id . ', ' . $main_group .', ' . $group_sorting . ', ' . $section_id . ' )', true) == false) {
                $res = $DB->Query('select ID from ' . self::tblGroups . ' where name = "' . $DB->ForSql(self::ConvertText($group_name)) . '" and iblock_id = ' . $iblock_id)->Fetch();
                return $res['ID'];
            } else {
                return $DB->LastID();
            }
        } else{
            return false;
        }
    }

    static function AddPropsToGroup($props, $iblock_id, $group_id)
    {
        global $DB;

        $group_id = intval($group_id);
        $iblock_id = intval($iblock_id);

        if (!is_array($props) || $iblock_id <= 0) {
            return false;
        }

            foreach ($props as $k => $v) {
                if (intval($v) > 0) {
                    $DB->Query('delete from ' . self::tblPropsToGroups . ' where PROPERTY_ID = ' . intval($v), true);
                    if ($group_id > 0) {
                        $DB->Query('insert into ' . self::tblPropsToGroups . ' ( `PROPERTY_ID`, `IBLOCK_ID`, `GROUP_ID`) values ( ' . intval($v) . ', ' . intval($iblock_id) . ', ' . intval($group_id) . ')', true);
                    }
                }
            }

        // $DB->Query('delete from ' . self::tblPropsToGroups . ' where group_id = ' . $group_id, true);
        // foreach ($props as $k => $v) {
        // if (intval($v) > 0) {
        // $DB->Query('insert into ' . self::tblPropsToGroups . ' ( `PROPERTY_ID`, `IBLOCK_ID`, `GROUP_ID`) values ( ' . intval($v) . ', ' . intval($iblock_id) . ', ' . intval($group_id) . ')', true);
        // }
        // }
    }

    static function updateIpepGroup($IBLOCK_ID, $arPropsSort){
        if (empty($IBLOCK_ID) || empty($arPropsSort) || !\CModule::IncludeModule('iblock')) return;
        foreach ($arPropsSort as $key => $SortProp){
            $arIDSort = explode('_',$SortProp);
            $arFields = array(
                "IBLOCK_ID" => $IBLOCK_ID,
                "SORT" => $arIDSort[1],
            );

            $ibp = new \CIBlockProperty;
            $ibp->Update($arIDSort[0], $arFields);
        }
    }
}
