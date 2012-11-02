<?php
$popupMeta = array (
    'moduleMain' => 'tag_Tagger',
    'varName' => 'tag_Tagger',
    'orderBy' => 'tag_tagger.name',
    'whereClauses' => array (
  'name' => 'tag_tagger.name',
  'monitored_module' => 'tag_tagger.monitored_module',
  'description' => 'tag_tagger.description',
  'encoded_monitored_fields' => 'tag_tagger.encoded_monitored_fields',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'monitored_module',
  5 => 'description',
  6 => 'encoded_monitored_fields',
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
  'monitored_module' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_MONITORED_MODULE',
    'width' => '10%',
    'name' => 'monitored_module',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'name' => 'description',
  ),
  'encoded_monitored_fields' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_ENCODED_MONITORED_FIELDS',
    'sortable' => false,
    'width' => '10%',
    'name' => 'encoded_monitored_fields',
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
    'name' => 'name',
  ),
  'MONITORED_MODULE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MONITORED_MODULE',
    'width' => '10%',
    'name' => 'monitored_module',
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'MONITORED_FIELDS' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_MONITORED_FIELDS',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
    'name' => 'monitored_fields',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
    'name' => 'description',
  ),
),
);
