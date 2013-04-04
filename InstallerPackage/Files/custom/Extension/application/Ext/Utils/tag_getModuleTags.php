<?php

function tag_getModuleTags()
{
    $tagObj = BeanFactory::newBean('tag_Tags');
    return $tagObj->getModuleTags($_REQUEST['module']);
}