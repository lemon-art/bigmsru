<?
$MESS ['TITLE'] = '<h1>yenisite.infoblockpropsplus</h1>';
$MESS ['IPEP_MAX_INPUT_VARS'] = "<p>Значение max_input_vars должно быть не ниже 10000. <p>";
$MESS ['IPEP_MAX_INPUT_VARS_Y'] = "<p style='color: green;'>Условие выполняется.</p>";
$MESS ['IPEP_MAX_INPUT_VARS_N'] = "<p style='color: red;'>Условие НЕ выполняется. Текущее значение: </p>";
$MESS ['TEXT'] = '
<br />
<br />
<h2>Описание API модуля:</h2>
<br />
<br />
<b>Возвращает группы свойств, идентификаторы свойств вошедших в группы и их комментарии для инфоблока или раздела:</b> <br />
<br />
<pre>CYenisiteInfoblockpropsplus::GetInitArray( <br />
 arFilter=array() <br />
);</pre>

<table cellpadding="7" border="1" width="100%">
<tr><td><b>Параметр</b></td><td><b>Описание</b></td></tr>
<tr><td>$arFilter</td><td>Принимает значения: <br />array("IBLOCK_ID" => ) - для инфоблока<br />и<br />array("IBLOCK_ID" => , "SECTION_ID" => ) - для раздела</td></tr>
</table>
<br />
<br />
<br />
<b>Добавить группу:</b> <br />
<br />
<pre>CYenisiteInfoblockpropsplus::AddGroup( <br />
 $iblock_id, <br />
 $group_name, <br />
 $group_sorting, <br />
 $section_id <br />
);</pre>

<table cellpadding="7" border="1" width="100%">
<tr><td><b>Параметр</b></td><td><b>Описание</b></td></tr>
<tr><td>$iblock_id</td><td>Идентификатор инфоблока</td></tr>
<tr><td>$group_name</td><td>Наименование группы</td></tr>
<tr><td>$group_sorting</td><td>Значение сортировки (число) - чем меньше значение параметра тем выше распологается группа</td></tr>
<tr><td>$section_id</td><td>Идентификатор раздела <br />Если параметр передается пустым, принимает значение по умолчанию равное "0".</td></tr>
</table>
<br />
<br />
<br />
<b>Удалить группу:</b> <br />
<br />
<pre>CYenisiteInfoblockpropsplus::RemoveGroup( <br />
 $group_id <br />
);</pre>

<table cellpadding="7" border="1" width="100%">
<tr><td><b>Параметр</b></td><td><b>Описание</b></td></tr>
<tr><td>$group_id</td><td>Идентификатор группы свойств.</td></tr>
</table>
<br />
<br />
<br />
<b>Обновить группу:</b> <br />
<br />
<pre>CYenisiteInfoblockpropsplus::UpdateGroup( <br />
 $group_id, <br />
 $group_name, <br />
 $group_sorting, <br />
 $iblock_id, <br />
 $section_id, <br />
 $in_section_edit <br />
);</pre>

<table cellpadding="7" border="1" width="100%">
<tr><td><b>Параметр</b></td><td><b>Описание</b></td></tr>
<tr><td>$group_id</td><td>Идентификатор группы которую нужно изменить<br />Обязательный параметр, в случае его отутствия будет добавлена новая группа с указанными параметрами ($group_name, $group_sorting, $iblock_id, $section_id)</td></tr>
<tr><td>$group_name</td><td>Новое наименование группы<br />Обязательный параметр</td></tr>
<tr><td>$group_sorting</td><td>Значение сортировки (число) - чем меньше значение параметра тем выше распологается группа<br />Необязательный параметр</td></tr>
<tr><td>$iblock_id</td><td>Идентификатор инфоблока<br />Обязательный параметр</td></tr>
<tr><td>$section_id</td><td>Новое значение идентификатора раздела<br />Если передается не число или пустое значение, идентификатор раздела не изменится<br />Должно принимать пустое значение если группа изменяется в общем списке свойств для инфоблока</td></tr>
<tr><td>$in_section_edit</td><td>Принимает значение "y" или "n": "y" - изменению подвергается группа для раздела, "n" - изменению подвергается для инфоблока <br />По умолчанию принимает занчение "n" <br />При изменении группы для раздела, данный параметр обязательно должен принимать значение "y" - изменение значения сортировки для раздела запрещено, т.к. может нарушить работу модуля для общего списка свойств для инфоблока.</td></tr>
</table>
<br />
<br />
<br />
<b>Добавить свойство в группу:</b> <br />
<br />
<pre>CYenisiteInfoblockpropsplus::AddPropsToGroup( <br />
 $props=array(), <br />
 $iblock_id, <br />
 $group_id <br />
);</pre>

<table cellpadding="7" border="1" width="100%">
<tr><td><b>Параметр</b></td><td><b>Описание</b></td></tr>
<tr><td>$props</td><td>массив идентификаторов свойств</td></tr>
<tr><td>$iblock_id</td><td>Идентификатор инфоблока</td></tr>
<tr><td>$group_id</td><td>Идентификатор группы свойств.</td></tr>
</table>
<br />
<br />
<br />
<b>Изменить комментарий:</b> <br />
<br />
<pre>CYenisiteInfoblockpropsplus::EditPropComment( <br />
 $prop_id, <br />
 $iblock_id, <br />
 $comment <br />
);</pre>

<table cellpadding="7" border="1" width="100%">
<tr><td><b>Параметр</b></td><td><b>Описание</b></td></tr>
<tr><td>$prop_id</td><td>Идентификатор свойства</td></tr>
<tr><td>$iblock_id</td><td>Идентификатор инфоблока</td></tr>
<tr><td>$comment</td><td>Новое значаение комментария.</td></tr>
</table>
<br />
<br />
<br />
<b>В модуле также вызываются следующие обработчики:</b>
<br />
<br />
<table cellpadding="7" border="1" width="100%">
<tr><td><b>Обработчик</b></td><td><b>Событие</b></td><td><b>Описание</b></td></tr>
<tr><td>OnIBlockDelete</td><td>OnIBlockDelete</td><td>В момент удаления информационного блока очищает группы привязанные к инфоблоку, привязку свойств к группам и их комментарии</td></tr>
<tr><td>OnIBlockPropertyDelete</td><td>OnIBlockPropertyDelete</td><td>В момент удаления свойства очищает привязку свойства к группам и его комментарии</td></tr>
</table>
';
?>