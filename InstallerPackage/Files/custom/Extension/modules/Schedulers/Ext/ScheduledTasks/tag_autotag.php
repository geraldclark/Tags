<?php

$job_strings[] = 'tag_autotag';

function tag_autotag()
{
    require_once('modules/tag_Tags/TagSettings.php');
    $settings = new TagSettings();

    $limit = $settings->limit->value;
    $days = $settings->limit->days;

    require('modules/tag_Taggers/Schedulers/AutoTag.php');

    return true;
}
