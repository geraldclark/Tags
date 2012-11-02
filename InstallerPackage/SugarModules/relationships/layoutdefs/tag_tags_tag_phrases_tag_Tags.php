<?php
 // created: 2012-11-02 00:55:45
$layout_defs["tag_Tags"]["subpanel_setup"]['tag_tags_tag_phrases'] = array (
  'order' => 100,
  'module' => 'tag_Phrases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TAG_TAGS_TAG_PHRASES_FROM_TAG_PHRASES_TITLE',
  'get_subpanel_data' => 'tag_tags_tag_phrases',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
