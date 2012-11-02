<?php

$job_strings[] = 'tag_autotag';

function tag_autotag()
{
    $configuratorObj = BeanFactory::newBean('tag_Tags')->getConfig();
    $limit = $configuratorObj->config['customTagSettings']['tagger']['limit'];
    $days = $configuratorObj->config['customTagSettings']['tagger']['days'];

    require('modules/tag_Taggers/Schedulers/AutoTag.php');

    return true;
}
