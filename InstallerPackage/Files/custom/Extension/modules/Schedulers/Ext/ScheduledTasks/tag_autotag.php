<?php

$job_strings[] = 'tag_autotag';

function tag_autotag()
{
    $module = '';
    require('modules/tag_Taggers/Schedulers/getModule.php');

    $settings = new TagSettings($module);

    $days = $settings->days->value;
    $limit = $settings->limit->value;

    //update run time
    $settings->scheduler_last_run->value = TimeDate::getInstance()->nowDb();
    $settings->scheduler_last_run->save();

    require('modules/tag_Taggers/Schedulers/autoTag.php');

    return true;
}
