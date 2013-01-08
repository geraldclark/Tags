<?php

require_once('modules/tag_Tags/Helpers/SettingHelper.php');

class TagSettings extends  SettingHelper
{
    /**
     * Define my custom settings for this plugin
     */
    public function __construct($section = '', $auto_create = true)
    {
        $tag_category = 'tag_Tags';
        $tagger_category = 'tag_Taggers';

        $this->session = new SettingString($auto_create, 'LBL_TAGGER_SESSION', $tagger_category, $section, 'session', 'Inactive', array('LBL_ACTIVE'=>'Active', 'LBL_INACTIVE'=>'Inactive'));
        $this->status = new SettingString($auto_create, 'LBL_TAGGER_STATUS', $tagger_category, $section, 'status', 'Inactive', array('LBL_ACTIVE'=>'Active', 'LBL_INACTIVE'=>'Inactive'));
        $this->behavior = new SettingString($auto_create, 'LBL_TAGGER_BEHAVIOR', $tagger_category, $section, 'behavior', 'Append', array('LBL_TAGGER_APPEND'=>'Append', 'LBL_TAGGER_REEVALUATE'=>'Reevaluate'));
        $this->limit = new SettingInteger($auto_create, 'LBL_TAGGER_LIMIT', $tagger_category, $section, 'limit',  200);
        $this->days = new SettingInteger($auto_create, 'LBL_TAGGER_DAYS', $tagger_category, $section, 'days', -1);
        $this->scheduler_last_run = new SettingDate($auto_create, '', $tagger_category, $section, 'scheduler_last_run', '', null, true);
        $this->acl = new SettingString($auto_create, 'LBL_TAG_ACL', $tag_category, $section, 'acl', 'Editable', array('LBL_EDITABLE'=>'Editable', 'LBL_LIMITED'=>'Limited', 'LBL_RESTRICTED'=>'Restricted'));
        $this->relationship = new SettingString($auto_create, '', $tag_category, $section, 'relationship', '');

        parent::__construct();
    }
}