<?php
 // created: 2012-11-02 00:55:45
$layout_defs["tag_Taggers"]["subpanel_setup"]['tag_taggers_tag_tags'] = array (
  'order' => 100,
  'module' => 'tag_Tags',
  'subpanel_name' => 'default',
  'sort_order' => 'desc',
  'sort_by' => 'date_modified',
  'title_key' => 'LBL_TAG_TAGGERS_TAG_TAGS_FROM_TAG_TAGS_TITLE',
  'get_subpanel_data' => 'tag_taggers_tag_tags',
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
