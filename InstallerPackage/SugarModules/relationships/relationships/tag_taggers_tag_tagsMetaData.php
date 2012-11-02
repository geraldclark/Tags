<?php
// created: 2012-11-02 00:55:45
$dictionary["tag_taggers_tag_tags"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'tag_taggers_tag_tags' => 
    array (
      'lhs_module' => 'tag_Taggers',
      'lhs_table' => 'tag_taggers',
      'lhs_key' => 'id',
      'rhs_module' => 'tag_Tags',
      'rhs_table' => 'tag_tags',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tag_taggers_tag_tags_c',
      'join_key_lhs' => 'tag_taggers_tag_tagstag_taggers_ida',
      'join_key_rhs' => 'tag_taggers_tag_tagstag_tags_idb',
    ),
  ),
  'table' => 'tag_taggers_tag_tags_c',
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
      'name' => 'tag_taggers_tag_tagstag_taggers_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tag_taggers_tag_tagstag_tags_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tag_taggers_tag_tagsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tag_taggers_tag_tags_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tag_taggers_tag_tagstag_taggers_ida',
        1 => 'tag_taggers_tag_tagstag_tags_idb',
      ),
    ),
  ),
);