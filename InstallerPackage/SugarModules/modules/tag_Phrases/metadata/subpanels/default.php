<?php
$module_name='tag_Phrases';
$subpanel_layout = array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'tag_Phrases',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'name' => 
    array (
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '10%',
      'default' => true,
    ),
    'phrase' => 
    array (
      'type' => 'text',
      'studio' => 'visible',
      'vname' => 'LBL_PHRASE',
      'sortable' => false,
      'width' => '30%',
      'default' => true,
    ),
    'regex' => 
    array (
      'type' => 'bool',
      'default' => true,
      'vname' => 'LBL_REGEX',
      'width' => '10%',
    ),
    'description' => 
    array (
      'type' => 'text',
      'vname' => 'LBL_DESCRIPTION',
      'sortable' => false,
      'width' => '40%',
      'default' => true,
    ),
    'date_modified' => 
    array (
      'vname' => 'LBL_DATE_MODIFIED',
      'width' => '10%',
      'default' => true,
    ),
    'edit_button' => 
    array (
      'widget_class' => 'SubPanelEditButton',
      'module' => 'tag_Phrases',
      'width' => '5%',
      'default' => true,
    ),
    'remove_button' => 
    array (
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'tag_Phrases',
      'width' => '5%',
      'default' => true,
    ),
  ),
);