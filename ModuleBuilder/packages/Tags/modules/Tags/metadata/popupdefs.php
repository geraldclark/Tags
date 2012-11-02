<?php
$popupMeta = array (
    'moduleMain' => 'tag_Tags',
    'varName' => 'tag_Tags',
    'orderBy' => 'tag_tags.name',
    'whereClauses' => array (
  'name' => 'tag_tags.name',
  'target_module' => 'tag_tags.target_module',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'target_module',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'target_module' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TARGET_MODULE',
    'width' => '10%',
    'name' => 'target_module',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'TARGET_MODULE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TARGET_MODULE',
    'width' => '10%',
  ),
),
);
