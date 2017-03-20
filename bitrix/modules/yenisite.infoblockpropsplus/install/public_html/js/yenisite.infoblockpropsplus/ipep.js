yeni_ipep = {
    loaded: false,
    $clonedAndClearedGroup: false,
    addedGroups: [],
    inSectionEdit: false,
    init: function () {
        var main_table = $('#edit2_edit_table .internal');

        if (yeni_ipep.loaded == true) {
            $('.adm-detail-content-item-block').hide().fadeIn(1000);
        }

        main_table.find('tr.heading').addClass('state-disabled')
        var colspans = main_table.find('tr.heading td').length + 1;

        main_table.find('tbody').before('<thead></thead>');
        main_table.find('thead').append(main_table.find('tbody tr').eq(0));

        main_table.append('<tr class="info" style="display: none;"><td colspan=' + colspans + ' align="center">' + BX.message('yeni_ipep_js_move_props_here') + '<input type="text" class="yeni_ipep_group_id" /></td></tr>');

        main_table.before(main_table.addClass('yeni_ipep_table').clone().addClass('yeni_ipep_can_move'));

        main_table.find('tr').each(function () {
            if (typeof($(this).attr('id')) != 'undefined' && !$(this).attr('id').match(/IB_PROPERTY_n/)) {
                $(this).remove();
            } else if (!$(this).hasClass('heading')) {
                $(this).find('td:first-of-type').remove();
            }
        });

        $('.yeni_ipep_can_move thead .heading').first().before('<tr><td class="group_header" colspan="' + colspans + '"><input type="button" class="yeni_ipep_remove_group first" value="' + BX.message('yeni_ipep_js_remove_group') + '" /><input type="button" class="yeni_ipep_add_group adm-btn-save adm-btn-add" value="' + BX.message('yeni_ipep_js_add_new_group') + '" /><input type="text" class="group_name" value="' + BX.message('yeni_ipep_js_group_def_title') + '" readonly/></td></tr>');
        $('.yeni_ipep_can_move .yeni_ipep_remove_group').hide();
        $('.yeni_ipep_table').last().addClass('yeni_ipep_new_props').find('.heading').first().before('<tr><td class="group_header" colspan="' + colspans + '"><input type="text" class="group_name" value="' + BX.message('yeni_ipep_js_adding_new_props') + '" readonly/></td></tr>');

        $('.yeni_ipep_table .group_header').closest('tr').addClass('state-disabled');

        $('.yeni_ipep_table').css('margin-top', '10px');
        $('.yeni_ipep_table').css('margin-bottom', '20px');
        $('.yeni_ipep_table .group_header').attr('style', 'padding: 7px 0 !important;');

        // add comment button
        $('.yeni_ipep_can_move tbody tr').each(function () {
            var textInput = $(this).find('td input[type=text]').first();
            if (!textInput.hasClass('yeni_ipep_group_id')) {
                textInput.after('<div class="comment_button_container"><div class="comment_button" title="' + BX.message('yeni_ipep_js_add_comment') + '"><div class="textarea_container"><textarea placeholder="' + BX.message('yeni_ipep_js_write_comment') + '" class="yeni_ipep_comment"></textarea></div></div></div>');
            }
        });

        $('.yeni_ipep_new_props tr').each(function () {
            if ($(this).hasClass('heading') || $(this).find('td:first-child.group_header')) {
                if ($(this).hasClass('heading')) {
                    $(this).find('td').first().remove();
                    $(this).find('td').last().remove();
                }
                return;
            }
            if ($(this).find('td').eq(0).text() != '') {
                $(this).remove();
                return;
            }

            $(this).find('td').first().remove();
            $(this).find('td').last().remove();
        });

        $('.yeni_ipep_can_move tr.heading td').first().before('<td></td>');
        $('.yeni_ipep_can_move tr').each(function () {
            if ($(this).hasClass('heading') || $(this).find('td').first().hasClass('group_header')) {
                return;
            }
            if ($(this).find('td').eq(0).text() == '') {
                $(this).remove();
            }
        });

        $('.yeni_ipep_table').find('.adm-list-table-popup').css('cursor', 'move')

        var propByID = [];

        var $tmpInsertBefore = '<td><div class="adm-list-table-popup" title="' + BX.message('yeni_ipep_js_move') + '"></div></td>';


        $('.yeni_ipep_table.yeni_ipep_can_move td:not(.notInt)').each(function () {
            if ($(this).text().length > 10) {
                return;
            }

            var numID = parseInt($(this).text());
            if (isNaN(numID)) {
                return;
            }


            propByID[numID] = $(this).closest('tr');
            if (!propByID[numID].hasClass('state-disabled') && !propByID[numID].hasClass('info')) {
                propByID[numID].find('td:first').before($tmpInsertBefore);
            }
        })

        if (typeof(yeni_ipep.props_comments) != 'undefined') {
            for (property_id in yeni_ipep.props_comments) {
                if (yeni_ipep.props_comments[property_id].length > 0 && typeof(propByID[property_id]) != 'undefined') {
                    propByID[property_id].find('.yeni_ipep_comment').val(yeni_ipep.props_comments[property_id]);
                }
            }
        }

        if (typeof(yeni_ipep.props_to_groups) != 'undefined') {
            var newDom = $('');
            var groupBodyByID = [];

            for (i in yeni_ipep.props_to_groups) {
                for (j in yeni_ipep.props_to_groups[i]) {
                    if (yeni_ipep.props_to_groups[i][j]['GROUP_ID'] != '') {
                        var group_id = parseInt(yeni_ipep.props_to_groups[i][j]['GROUP_ID']);
                        var group_name = yeni_ipep.props_to_groups[i][j]['GROUP_NAME'];
                        var prop_id = parseInt(yeni_ipep.props_to_groups[i][j]['PROPERTY_ID']);

                        if (typeof(yeni_ipep.addedGroups[group_id]) == 'undefined') {
                            newDom.after(yeni_ipep.add_group(false, group_id, group_name, false, true));
                            groupBodyByID[group_id] = newDom.find('.yeni_ipep_group_id[value=' + group_id + ']').closest('table').find('tbody');
                            yeni_ipep.addedGroups[group_id] = true;
                        }

                        if(!isNaN(prop_id)){
                            groupBodyByID[group_id].append(propByID[prop_id]).find('tr.info').hide();
                        }else{
                            groupBodyByID[group_id].append(propByID[prop_id]).find('tr.info').show();
                        }
                    }
                }
            }
            $('.yeni_ipep_can_move').last().after(newDom);

            newDom = null;
            propByID = null;
            groupBodyByID = null;
        }

        $('.yeni_ipep_table').first().addClass('form-state-disabled');

        // handler for detail change prop
        $('body').on('click', '.yeni_ipep_table input[type=button]', function (e) {
            if (($(this).attr('name') != undefined) && ($(this).attr('name').indexOf('IB_PROPERTY_') != -1) && (!isNaN($(this).attr('data-propid')))) {
                BX.proxy_context = e.target;
                obIBProps.ShowPropertyDialog(e);
            }
        });

        $('body').on('focus', '.yeni_ipep_table .group_header .group_name[readonly="readonly"]', function () {
            $(this).blur();
        });

        $('body').on('click', '.yeni_ipep_add_group', function () {
            yeni_ipep.add_group($(this));
        });

        $('body').on('click', '.yeni_ipep_remove_group', function () {
            yeni_ipep.remove_group($(this));
        });

        $('body').on('keydown', '.yeni_ipep_table .group_header input[type=text]', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                $(this).blur();
            }
        });

        $('body').on('change', '.yeni_ipep_table .group_header input[type=text]', function (e) {
            var findedCnt = 0;
            var curVal = $(this).val();
            $('.group_header input[type=text]').each(function () {
                if ($(this).val() == curVal) {
                    findedCnt++;
                }
            });
            if (findedCnt < 2) {
                yeni_ipep.saveGroups();
            } else {
                e.preventDefault();
                alert( BX.message('yeni_ipep_js_gtoup_exist') );
                $(this).trigger('focus').val( BX.message('yeni_ipep_js_input_name_of_group') );
                return false;
            }
        });
        $('body').on('submit', '#frm_prop', function () {
            if ($('#PROPERTY_HINT').length > 0) {
                var $prop_id_input = $(this).find('input[name=propedit]');
                if ($prop_id_input.length > 0) {
                    $('#IB_PROPERTY_' + $prop_id_input.val()).find('textarea.yeni_ipep_comment').val($('#PROPERTY_HINT').val());
                }
            }
        });

        $('#edit2_edit_table div').last().find('input').on('click', function () {
            $('.yeni_ipep_new_props tbody tr').each(function () {
                if ($(this).find('td').first().find('input').length != 0) {
                    return;
                }

                $(this).find('td').first().remove();
                $(this).find('td').last().remove();
            });
        });

        // for comment start
        $('body').on('blur', '.yeni_ipep_table .textarea_container textarea', function () {
            $('.yeni_ipep_table .textarea_container').fadeOut('fast');
        });

        $('body').on('change', '.yeni_ipep_table .textarea_container textarea', function () {
            yeni_ipep.saveComment($(this));
        });

        $('body').on('click', '.yeni_ipep_table .comment_button', function () {
            $(this).find('.textarea_container').fadeIn('fast', function () {
                $(this).find('textarea').focus()
            });
        });
        // for comment end

        setTimeout('yeni_ipep.loaded = true;yeni_ipep.makeSortable();', 3000);
    },

    init_cat_section: function () {
        arSortProps = new Array();
        yeni_ipep.inSectionEdit = true;
        // set view-mode FLAT
        setMode(BX('table_SECTION_PROPERTY'), 'flat');
        $('.yeni_ipep_table').remove();
        main_table = $('#table_SECTION_PROPERTY');
        main_table.addClass('section-table-drag');
        copy_main_table = $('#table_SECTION_PROPERTY').clone();

        $('body').one('click', '#modeChangeToTree', function () {
            main_table.after(copy_main_table);
            $('.yeni_ipep_table').remove();
        });
        $('body').one('click', '#modeChangeToFlat', function () {
            BX.showWait();
            $.getJSON('/bitrix/js/yenisite.infoblockpropsplus/ajax.php?action=getinitarray&iblock_id=' + yeni_ipep.cur_iblock_id, function (data) {

                yeni_ipep.props_to_groups = data.PROPS_TO_GROUPS;
                yeni_ipep.props_comments = data.PROPS_COMMENTS;
                // set timeout because need time for work bitrix JS
                //setTimeout(function() { yeni_ipep.init_cat_section(); }, 25);
                yeni_ipep.init_cat_section();
                BX.closeWait();
            });

        });
        var alertMess = $('<div class="alert-mess-section">'+BX.message('yeni_ipep_js_alert_for_section')+'</div>');
        main_table.before(alertMess);
        main_table.find('tr.heading').addClass('state-disabled');
        var colspans = main_table.find('tr.heading td').length + 1;

        main_table.find('tbody').before('<thead></thead>');
        main_table.find('thead').append(main_table.find('tbody tr[mode = flat]').eq(0));

        main_table.append('<tr class="info" style="display: none;"><td colspan=' + colspans + ' align="center">' + BX.message('yeni_ipep_js_move_props_here') + '<input type="text" class="yeni_ipep_group_id" /></td></tr>');

        main_table.addClass('yeni_ipep_table').addClass('yeni_ipep_can_move');

        // insert head before table
        $('.yeni_ipep_can_move thead .heading').first().before('<tr><td class="group_header" colspan="' + colspans + '"><input type="button" class="yeni_ipep_remove_group first" value="' + BX.message('yeni_ipep_js_remove_group') + '" /><input type="button" class="yeni_ipep_add_group adm-btn-save adm-btn-add" value="' + BX.message('yeni_ipep_js_add_new_group') + '" /><b>' + BX.message('yeni_ipep_js_bind_group_to_section') + '<input type="checkbox" name="GROUP_0" id="GROUP_0" value="Y" class="adm-designed-checkbox"><label class="adm-designed-checkbox-label" for="GROUP_0" title=""></label></b><input type="text" class="group_name" value="' + BX.message('yeni_ipep_js_group_def_title') + '" readonly/></td></tr>');

        // hide delete_group button
        $('.yeni_ipep_can_move .yeni_ipep_remove_group').hide();

        $('.yeni_ipep_table .group_header').closest('tr').addClass('state-disabled');
        main_table.find('tr[mode = tree ]').addClass('state-disabled');

        $('.yeni_ipep_table').css('margin-top', '10px');
        $('.yeni_ipep_table').css('margin-bottom', '20px');
        $('.yeni_ipep_table .group_header').attr('style', 'padding: 7px 0 !important;');

        // add comment button
        $('.yeni_ipep_can_move tbody tr:not(.info)').each(function () {
            var textInput = $(this).find('td').first();
            if (!textInput.hasClass('yeni_ipep_group_id')) {
                textInput.append('<div class="comment_button_container"><div class="comment_button" title="' + BX.message('yeni_ipep_js_add_comment') + '"><div class="textarea_container"><textarea placeholder="' + BX.message('yeni_ipep_js_write_comment') + '" class="yeni_ipep_comment"></textarea></div></div></div>');
            }
        });
        $('.comment_button').css('top', '-29px');

        main_table.find('tr td.internal-left').removeClass('internal-left');

      //  $('.yeni_ipep_can_move tr.heading td:first-of-type').before('<td class="internal-left"></td>');
        $('.yeni_ipep_can_move tr').each(function () {
            if ($(this).hasClass('heading') || $(this).find('td').first().hasClass('group_header')) {
                return;
            }
            if ($(this).find('td').eq(0).text() == '') {
                $(this).remove();
            }
        });

       /* $('.yeni_ipep_can_move tr:not(.state-disabled, .info)').each(function () {
            $(this).find('td').first().before('<td class="internal-left"><div class="adm-list-table-popup" title="' + BX.message('yeni_ipep_js_move') + '"></div></td>');
        });*/

        $('.yeni_ipep_table').find('.adm-list-table-popup').css('cursor', 'move');

        // delete handler with 'off' because use repeat yeni_ipep.init_cat_section() at change view mode(tree->flat)
        $('body').off('click', '.yeni_ipep_add_group');
        $('body').on('click', '.yeni_ipep_add_group', function add_group() {
            yeni_ipep.add_group($(this));
        });

        $('body').off('click', '.yeni_ipep_remove_group');
        $('body').on('click', '.yeni_ipep_remove_group', function () {
            yeni_ipep.remove_group($(this));
        });

        // if push Enter in intup-name-of-group
        $('body').off('keydown', '.yeni_ipep_table .group_header input[type=text]');
        $('body').on('keydown', '.yeni_ipep_table .group_header input[type=text]', function (e) {
            if (e.which == 13) {
                e.preventDefault();	// delete another handler
                $(this).blur();		// hide input
            }
        });


        $('body').off('change', '.yeni_ipep_table .group_header input[type=text]');
        $('body').on('change', '.yeni_ipep_table .group_header input[type=text]', function (e) {
            var findedCnt = 0;
            var curVal = $(this).val();
            $('.group_header input[type=text]').each(function () {
                if ($(this).val() == curVal) {
                    findedCnt++;
                }
            });
            if (findedCnt < 2) {
                yeni_ipep.saveGroups($(this));
            } else {
                e.preventDefault();
                alert( BX.message('yeni_ipep_js_gtoup_exist') );
                $(this).trigger('focus').val( BX.message('yeni_ipep_js_input_name_of_group') );
                return false;
            }
        });

        $('body').off('change', '.yeni_ipep_table .group_header input[type=checkbox]');
        $('body').on('change', '.yeni_ipep_table .group_header input[type=checkbox]', function () {
            yeni_ipep.saveGroups();
        });

        // for comment start
        $('body').off('blur', '.yeni_ipep_table .textarea_container textarea');
        $('body').on('blur', '.yeni_ipep_table .textarea_container textarea', function () {
            $('.yeni_ipep_table .textarea_container').fadeOut('fast');
        });

        $('body').off('change', '.yeni_ipep_table .textarea_container textarea');
        $('body').on('change', '.yeni_ipep_table .textarea_container textarea', function () {
            yeni_ipep.saveComment($(this));
        });

        $('body').off('click', '.yeni_ipep_table .comment_button');
        $('body').on('click', '.yeni_ipep_table .comment_button', function () {
            $(this).find('.textarea_container').fadeIn('fast', function () {
                $(this).find('textarea').focus()
            });
        });
        // for comment end

        $('body').off('focus', '.yeni_ipep_table .group_header .group_name[readonly="readonly"]');
        $('body').on('focus', '.yeni_ipep_table .group_header .group_name[readonly="readonly"]', function () {
            $(this).blur();
        });
        // add tables of all groups
        if (typeof(yeni_ipep.props_to_groups) != 'undefined') {
            for (i in yeni_ipep.props_to_groups) {
                for (j in yeni_ipep.props_to_groups[i]) {
                    if (yeni_ipep.props_to_groups[i][j]['GROUP_ID'] != '') {
                        yeni_ipep.add_group(false, yeni_ipep.props_to_groups[i][j]['GROUP_ID'], yeni_ipep.props_to_groups[i][j]['GROUP_NAME'], yeni_ipep.props_to_groups[i][j]['GROUP_SECTION_ID']);
                        if (yeni_ipep.props_to_groups[i][j]['PROPERTY_ID'] != '') {
                            yeni_ipep.move_prop_cat_section(yeni_ipep.props_to_groups[i][j]['PROPERTY_ID'], yeni_ipep.props_to_groups[i][j]['GROUP_ID']);
                        }
                    }
                }
            }
        }
        main_table.find('.group_header b').remove();
        $('body').off('click', '.yeni_ipep_table .comment_button');
        $('body').on('click', '.yeni_ipep_table .comment_button', function () {
            $(this).find('.textarea_container').fadeIn('fast', function () {
                $(this).find('textarea').focus()
            });
        });


        $('.yeni_ipep_table').first().addClass('form-state-disabled');

        if (typeof(yeni_ipep.props_comments) != 'undefined') {
            for (property_id in yeni_ipep.props_comments) {
                if (yeni_ipep.props_comments[property_id].length > 0) {
                    $('tr[prop_id="' + property_id + '"]').find('.yeni_ipep_comment').val(yeni_ipep.props_comments[property_id]);
                }
            }
        }

        yeni_ipep.loaded = true;

        yeni_ipep.getSortForSection();
       // yeni_ipep.makeSortable();
        yeni_ipep.resortProps();

    },
    add_group: function (click_from, group_id, group_name, group_section_id, onlyReturn) {
        if (typeof(group_id) != 'undefined') {
            if ($('.yeni_ipep_group_id[value=' + group_id + ']').length > 0) {
                return;
            }
        }

        if (yeni_ipep.loaded == true) {
            $('.yeni_ipep_add_group').fadeOut();
        }

        if (typeof(group_id) != 'undefined') {
            var nearestTable = $('.yeni_ipep_can_move').last();
        } else {
            var nearestTable = $(click_from).closest('.yeni_ipep_table');
        }

        if (yeni_ipep.$clonedAndClearedGroup == false) {
            yeni_ipep.$clonedAndClearedGroup = nearestTable.clone().addClass('last');
            yeni_ipep.$clonedAndClearedGroup.find('tbody tr:not(.info)').remove();
            yeni_ipep.$clonedAndClearedGroup.removeClass('form-state-disabled');
            yeni_ipep.$clonedAndClearedGroup.find('tbody .info').show();
        }

        var last = yeni_ipep.$clonedAndClearedGroup.clone();

        if (typeof(group_id) == 'undefined') {
            last.find('.group_header input[type=text]').attr('readonly', false).val(BX.message('yeni_ipep_js_write_title')).focus().select();
            last.find('.yeni_ipep_group_id').val('');

        } else {
            last.find('.group_header input[type=text]').attr('readonly', false).val(group_name);
            last.find('.yeni_ipep_group_id').val(group_id);
        }

        if (typeof(group_id) != 'undefined' && yeni_ipep.loaded == true) {
            $('.yeni_ipep_add_group').stop().fadeIn();
            if (!yeni_ipep.inSectionEdit) {
                yeni_ipep.makeSortable();
            }
        }

        // add checkbox for bind group to section
        if (typeof(group_id) != 'undefined' && typeof(group_section_id) != 'undefined') {
            var checkbox = last.find('.group_header input[type=checkbox]');
            if (checkbox.length > 0 && yeni_ipep.cur_section_id > 0) {
                checkbox.attr('name', 'GROUP_' + group_id);
                checkbox.attr('id', 'GROUP_' + group_id);
                last.find('.group_header label.adm-designed-checkbox-label').attr('for', 'GROUP_' + group_id);
                if (group_section_id > 0) {
                    if (group_section_id == yeni_ipep.cur_section_id) {
                        // group bind to current section
                        checkbox.prop('checked', true);
                        checkbox.prop('disabled', false);
                    }
                    else {
                        // group bind to any of parent section
                        checkbox.prop('checked', true);
                        checkbox.prop('disabled', true);
                    }
                }
                else {
                    // group not bind to any section
                    checkbox.prop('disabled', false);
                    checkbox.prop('checked', false);
                }
            }
        }

        last.find('.yeni_ipep_remove_group').removeClass('first').show();
        last.removeClass('last');

        if (onlyReturn) {
            return last;
        } else {
            nearestTable.after(last);
            if (typeof(group_id) == 'undefined') {
                $.scrollTo(last, {
                    duration: 900, axis: 'y', onAfter: function () {
                        $.scrollTo({top: '-=200'}, {
                            duration: 400, axis: 'y', easing: 'swing', onAfter: function () {
                                if (yeni_ipep.loaded == true) {
                                    $('.yeni_ipep_add_group').stop().fadeIn();
                                }
                                if (!yeni_ipep.inSectionEdit) {
                                    yeni_ipep.makeSortable();
                                }
                            }
                        });
                    }
                });
            }
        }
    },

    remove_group: function (click_from) {
        $('.yeni_ipep_remove_group').fadeOut();

        var curTable = click_from.closest('.yeni_ipep_table');
        var firstTableBody = $('.yeni_ipep_table tbody').first();

        var group_id = curTable.find('.yeni_ipep_group_id').val();
        if (typeof(group_id) == 'undefined') {
            return;
        }

        curTable.find('tbody tr:not(.info)').each(function () {
            firstTableBody.append($(this).clone());
            $(this).fadeOut('fast', function () {
                $(this).remove();
            });
        });

        curTable.fadeOut('fast', function () {
            $(this).remove();
            $.getJSON('/bitrix/js/yenisite.infoblockpropsplus/ajax.php?action=remove_group&iblock_id=' + yeni_ipep.cur_iblock_id + '&group_id=' + group_id);
        });

        $.scrollTo($('.yeni_ipep_table').first(), {
            duration: 1000, axis: 'y', easing: 'swing', onAfter: function () {
                yeni_ipep.makeSortable();
                $('.yeni_ipep_remove_group:not(.first)').stop().fadeIn();
            }
        });
    },

    move_prop_cat_section: function (prop_id, group_id) {
        $('.yeni_ipep_table tr:not(.state-disabled)').each(function () {
            if ($(this).attr('prop_id') != prop_id || typeof($(this).attr('prop_id')) == 'undefined' || $(this).attr('mode') == 'none') {
                return;
            }
            var cur_group_tbody = $('.yeni_ipep_group_id[value=' + group_id + ']').closest('table').find('tbody');
            var cur_tr = $(this).closest('tr');
            cur_group_tbody.append(cur_tr.clone());

            cur_tr.remove();

            cur_group_tbody.find('tr.info').hide();

            return false;
        })
    },

    makeSortable: function () {
        if (yeni_ipep.loaded != true) {
            return;
        }
        $('.adm-detail-content-item-block tbody').sortable({
            items: $(".yeni_ipep_can_move"),
            cancel: "input, select, tr.info, textarea, .form-state-disabled",
            connectWith: $('.adm-detail-content-item-block').find('tbody').first(),
            stop: function (event, ui) {
                yeni_ipep.saveGroups();
            }
        });

        $('.yeni_ipep_can_move tbody').sortable({
            items: "tr",
            cancel: "input, select, tr.info, textarea",
            connectWith: $('.yeni_ipep_can_move tbody'),
            stop: function (event, ui) {
                yeni_ipep.resortProps();
            }
        });


    },

    getSortForSection : function (){
        $('.yeni_ipep_table tbody').each(function () {
            if ($(this).find('tr:not(.info, [mode=none], [mode=tree])').length == 0) {
              return;
            } else {
                $(this).find('tr').each(function () {
                        if (typeof $(this).attr('prop_sort') != 'undefined')
                            arSortProps.push($(this).attr('prop_sort'));
                    }
                );
            }
        });
        $('.yeni_ipep_can_move tbody').sortable({
            items: "tr",
            cancel: "input, select, tr.info, textarea",
            connectWith: $('.yeni_ipep_can_move tbody'),
            stop: function (event, ui) {
               yeni_ipep.saveGroups();
            }
        });		
        arSortProps.sort(yeni_ipep.compareNumeric);
    },

    resortProps: function () {
        var sortIndex = 0;
        newSort = 10;
        $('.yeni_ipep_table tbody').each(function () {

                //if ($(this).find('tr').length == 1) {
                if ($(this).find('tr:not(.info, [mode=none], [mode=tree])').length == 0) {
                    if (yeni_ipep.loaded == true) {
                        $(this).find('tr.info').fadeIn();
                    }
                } else {
                    $(this).find('tr.info').hide();
                    $(this).find('tr').each(function () {
                            if ($(this).find('input[type=text]:not([type=hidden])').eq(1).length > 0) {
                                if(typeof arSortProps != 'undefined') {
                                    $(this).find('input[type=text]:not([type=hidden])').eq(1).val(arSortProps[sortIndex]);
                                } else{
                                    $(this).find('input[type=text]:not([type=hidden])').eq(1).val(newSort);
                                }
                                newSort += 10;
                            }
                            if(typeof $(this).attr('prop_id') != 'undefined' && typeof arSortProps != 'undefined'){
                                $(this).attr('prop_sort',arSortProps[sortIndex]);
                                sortIndex++;
                            }
                        }
                    );
                }
            }
        );

        yeni_ipep.saveGroups();
    },

    saveComment: function (textarea) {
        var prop_id = textarea.closest('tr').attr('prop_id');
        if (typeof(prop_id) == 'undefined') {
            prop_id = textarea.closest('tr').find('td').eq(1).text();
        }

        if (prop_id != '') {
            $.post('/bitrix/js/yenisite.infoblockpropsplus/ajax.php', {
                'action': 'edit_prop_comment',
                'iblock_id' : yeni_ipep.cur_iblock_id,
                'prop_id': prop_id,
                'comment': encodeURIComponent(textarea.val()),
                'prop_info': $('#IB_PROPERTY_' + prop_id + '_PROPINFO').val()
            }, function(response) {
                if(typeof(response.prop_info) != 'undefined') {
                    $('#IB_PROPERTY_' + prop_id + '_PROPINFO').val(response.prop_info);
                }
            }, 'json');
        }
    },

    saveGroups: function ($this) {
        if (yeni_ipep.loaded != true) {
            return true;
        }
        var group_sorting = 0;
        $('.yeni_ipep_table').each(function () {

            var group_id = $(this).find('.yeni_ipep_group_id').val();


            if ($(this).find('.group_name').attr('readonly') == 'readonly') {
                group_id = -1; // for props without group
            }
            var group_props = [];
            var group_proprs_sort = [];

            $(this).find('tbody tr:visible').each(function () {

                var prop_id = $(this).attr('prop_id');
                var prop_sort = $(this).attr('prop_sort');
                if (typeof(prop_id) == 'undefined')
                    var prop_id = $(this).find('td').eq(1).text();
                if ((prop_id != '' || prop_id != 'undefined') && prop_id > 0) {
                    group_props.push(prop_id);
                    group_proprs_sort.push(prop_id + '_' + prop_sort);
                }
            });

            var group_name = $(this).find('.group_name').val();

            var checkbox = $(this).find('.group_header input[type=checkbox]:enabled');
            if (yeni_ipep.cur_section_id > 0 && checkbox.length > 0) {
                if (checkbox.prop('checked') == true)
                    var param_section_id = '&group_section=' + yeni_ipep.cur_section_id;
                else
                    var param_section_id = '&group_section=0';
            }
            else
                var param_section_id = '';

            var thisForAjax = $(this);
            group_sorting += 10;
            $.getJSON('/bitrix/js/yenisite.infoblockpropsplus/ajax.php?action=add_group&iblock_id=' + yeni_ipep.cur_iblock_id + '&in_section_edit=' + (yeni_ipep.inSectionEdit ? 'y' : 'n') + '&group_id=' + group_id + '&group_name=' + encodeURIComponent(group_name) + '&group_sorting=' + group_sorting + '&group_props=' + group_props.join(',') + param_section_id + '&props_sort=' + JSON.stringify(group_proprs_sort), function (data) {
                if (typeof(data.new_group_id) != 'undefined') {
                    thisForAjax.find('.yeni_ipep_group_id').val(data.new_group_id);
                } else if(data.IS_ERROR && data.ERROR_CODE == 'CANT_ADD_GROUP'){
                    alert( BX.message('yeni_ipep_js_gtoup_exist') );
                    if(typeof $this != 'undefined') {
                        $this.trigger('focus').val(BX.message('yeni_ipep_js_input_name_of_group'));
                    }
                }
            });
        });
    },

   /* bubbleSort: function(arSort){
        var i, j,t;
        for (i=0;i<arSort.length;i++){
           var min = i;
            for(j=i+1;j<arSort.length;j++){
                if (arSort[min] > arSort[j]){
                    min = j;
                    t = arSort[min];
                    arSort[min] = arSort[i];
                    arSort[i] = t;
                }
            }

        }
        return arSort;
    },*/

    compareNumeric: function(a, b) {
        return a - b;
    }

}

