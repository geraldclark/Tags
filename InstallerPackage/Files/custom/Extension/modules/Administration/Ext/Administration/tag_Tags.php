<?php

    //Tags
    $admin_option_defs=array();
    $admin_option_defs['Administration']['Tags_Tags'] = array('Administration','LBL_TAG_SETTINGS','LBL_TAG_SETTINGS_DESCRIPTION','index.php?module=tag_Tags&action=Settings');
    $admin_group_header[]= array('LBL_TAGS_MANAGEMENT', '', false, $admin_option_defs, '');