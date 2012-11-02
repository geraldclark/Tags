<?php
// created: 2012-11-02 00:55:45
$dictionary["tag_tags_tag_phrases"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'tag_tags_tag_phrases' => 
    array (
      'lhs_module' => 'tag_Tags',
      'lhs_table' => 'tag_tags',
      'lhs_key' => 'id',
      'rhs_module' => 'tag_Phrases',
      'rhs_table' => 'tag_phrases',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tag_tags_tag_phrases_c',
      'join_key_lhs' => 'tag_tags_tag_phrasestag_tags_ida',
      'join_key_rhs' => 'tag_tags_tag_phrasestag_phrases_idb',
    ),
  ),
  'table' => 'tag_tags_tag_phrases_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'tag_tags_tag_phrasestag_tags_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tag_tags_tag_phrasestag_phrases_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tag_tags_tag_phrasesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tag_tags_tag_phrases_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tag_tags_tag_phrasestag_tags_ida',
        1 => 'tag_tags_tag_phrasestag_phrases_idb',
      ),
    ),
  ),
);