<?php

require_once('modules/tag_Tags/Helpers/SettingHelper.php');

class TagSettings extends  SettingHelper
{
    /**
     * Define my custom settings for this plugin
     */
    public function __construct()
    {
        $tag_category = 'tag_Tags';
        $tagger_category = 'tag_Taggers';

        $this->session = new SettingString($tagger_category, 'session', 'Inactive', array('Active', 'Inactive'));
        $this->status = new SettingString($tagger_category, 'status', 'Inactive', array('Active', 'Inactive'));
        $this->behavior = new SettingString($tagger_category, 'behavior', 'Append', array('Append', 'Reevaluate'));
        $this->limit = new SettingInteger($tagger_category, 'limit',  200);
        $this->days = new SettingInteger($tagger_category, 'days', -1);
        $this->acl = new SettingString($tag_category, 'acl', 'Editable', array('Editable', 'Limited', 'Restricted'));
        $this->relationships = new SettingArray($tag_category, 'relationships', array());

        parent::__construct();
    }
}