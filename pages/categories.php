<?php

$func = rex_request('func', 'string');

if ($func == 'delete') {
    $id = (rex_request('id', 'int'));
    $sql = rex_sql::factory();

    // $sql->setDebug();

    $sql->setQuery('SELECT * FROM rex_aufgaben WHERE category =' . $id);

    if ($sql->getRows() > 0)
    {
        echo '<div class="alert alert-danger">'.$this->i18n('aufgaben_categories_category_in_use').'</div>';
    }
    else
    {
        $sql->setTable('rex_aufgaben_categories');
        $sql->setWhere('id = ' . $id);

        if ($sql->delete())
        {
            echo '<div class="alert alert-success">'.$this->i18n('aufgaben_categories_category_deleted').'</div>';
        }
    }

    $func = '';
}

if ($func == '') {
    $list = rex_list::factory("SELECT * FROM " . rex::getTablePrefix() . "aufgaben_categories ORDER BY category ASC");
    $list->addTableAttribute('class', 'table-striped');
    $list->setNoRowsMessage('<div class="alert alert-info" role="alert">'.$this->i18n('aufgaben_categories_no_category').'</div>');

    // icon column
    $thIcon = '<a href="' . $list->getUrl(['func' => 'add']) . '" title="'.$this->i18n('aufgaben_categories_category_add').'"><i class="rex-icon rex-icon-add-action"></i></a>';
    $tdIcon = '<i class="rex-icon fa-file-text-o"></i>';
    $list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
    $list->setColumnParams($thIcon, ['func' => 'edit', 'id' => '###id###']);

    $list->setColumnLabel('category', $this->i18n('aufgaben_categories_category'));
    $list->setColumnParams('category', ['func' => 'edit', 'id' => '###id###']);


    $list->setColumnLabel('color', $this->i18n('aufgaben_categories_color'));
    $list->setColumnLayout('color', ['<th>###VALUE###</th>', '<td data-title="'.$this->i18n('aufgaben_categories_color').'" class="td_aufgaben"><span style="border-bottom: 5px solid ###VALUE###;">###VALUE###</span></td>']);


    $delete = 'deleteCol';
    $list->addColumn($delete, '<i class="rex-icon rex-icon-delete"></i> '.$this->i18n('aufgaben_categories_category_delete'), -1, ['<th></th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams($delete, ['id' => '###id###', 'func' => 'delete']);

    $list->addLinkAttribute($delete, 'data-confirm', rex_i18n::msg('delete') . ' ?');
    $list->removeColumn('id');
    $content = '<div id="aufgaben">' . $list->get() . '</div>';
    $fragment = new rex_fragment();
    $fragment->setVar('title', $this->i18n('aufgaben_categories_title'));
    $fragment->setVar('content', $content, false);
    $content = $fragment->parse('core/page/section.php');
    echo $content;
}
elseif ($func == 'edit' || $func == 'add') {
    $fieldset = $func == 'edit' ? $this->i18n('aufgaben_categories_category_edit') : $this->i18n('aufgaben_categories_category_add');
    $id = rex_request('id', 'int');
    $form = rex_form::factory(rex::getTablePrefix() . 'aufgaben_categories', '', 'id=' . $id);
    $field = $form->addTextField('category');
    $field->setLabel($this->i18n('aufgaben_categories_category'));

    $field->getValidator()->add('notEmpty', $this->i18n('aufgaben_categories_category_empty'));

    $field = $form->addSelectField('color');
    $field->setPrefix('<div class="colorpicker">');
    $field->setSuffix('</div>');
    $field->setLabel($this->i18n('aufgaben_categories_color'));
    $select =$field->getSelect();
    $select->addOption('#000000','#000');
    $select->addOption('#607D8B','#607D8B');
    $select->addOption('#9E9E9E','#9E9E9E');
    $select->addOption('#795548','#795548');
    $select->addOption('#FF5722','#FF5722');
    $select->addOption('#FF9800','#FF9800');
    $select->addOption('#FFC107','#FFC107');
    $select->addOption('#FFEB3B','#FFEB3B');
    $select->addOption('#CDDC39','#CDDC39');
    $select->addOption('#8BC34A','#8BC34A');
    $select->addOption('#4CAF50','#4CAF50');
    $select->addOption('#009688','#009688');
    $select->addOption('#00BCD4','#00BCD4');
    $select->addOption('#03A9F4','#03A9F4');
    $select->addOption('#2196F3','#2196F3');
    $select->addOption('#3F51B5','#3F51B5');
    $select->addOption('#673AB7','#673AB7');
    $select->addOption('#9C27B0','#9C27B0');
    $select->addOption('#E91E63','#E91E63');
    $select->addOption('#F44336','#F44336');
    if ($field->getValue()== "") {
        $field->setValue('#000000');
    }

    if ($func == 'edit') {
        $form->addParam('id', $id);
    }

    $content = $form->get();
    $fragment = new rex_fragment();
    $fragment->setVar('class', 'edit', false);
    $fragment->setVar('title', "$fieldset");
    $fragment->setVar('body', $content, false);
    $content = '<div id="aufgaben">' . $fragment->parse('core/page/section.php') . '</div>';
    echo $content;
}
?>
<script>
 $('.colorpicker select').simplecolorpicker({
  picker: true
}).on('change', function() {
  $(document.body).css('background-color', $('select[name="colorpicker"]').val());
});
</script>

