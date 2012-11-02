<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
* Smarty plugin to retrieve tags as an array
*/

function smarty_function_tag_get_tags($params, &$smarty)
{
    if(empty($params['module']))
    {
		$smarty->trigger_error("tag_get_tags: missing 'module' parameter");
	}

    $tagObj = BeanFactory::newBean('tag_Tags');
    $tags = $tagObj->getModuleTags($params['module']);

    $smarty->assign('tags', $tags);
}

?>