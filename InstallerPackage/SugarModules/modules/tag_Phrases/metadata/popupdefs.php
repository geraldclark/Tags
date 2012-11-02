<?php
$popupMeta = array (
    'moduleMain' => 'tag_Phrases',
    'varName' => 'tag_Phrases',
    'orderBy' => 'tag_phrases.name',
    'whereClauses' => array (
  'phrase_number' => 'tag_phrases.phrase_number',
  'phrase' => 'tag_phrases.phrase',
  'regex' => 'tag_phrases.regex',
),
    'searchInputs' => array (
  4 => 'phrase_number',
  5 => 'phrase',
  6 => 'regex',
),
    'searchdefs' => array (
  'phrase_number' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PHRASE_NUMBER',
    'width' => '10%',
    'name' => 'phrase_number',
  ),
  'phrase' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_PHRASE',
    'sortable' => false,
    'width' => '10%',
    'name' => 'phrase',
  ),
  'regex' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_REGEX',
    'width' => '10%',
    'name' => 'regex',
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
  'PHRASE' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_PHRASE',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
    'name' => 'phrase',
  ),
  'REGEX' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_REGEX',
    'width' => '10%',
    'name' => 'regex',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
),
);
