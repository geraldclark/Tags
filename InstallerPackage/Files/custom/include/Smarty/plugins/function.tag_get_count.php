<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
* Smarty plugin to retrieve the records tag count
*/

function smarty_function_tag_get_count($params, &$smarty)
{
    if(empty($params['module']))
    {
		$smarty->trigger_error("tag_get_count: missing 'module' parameter");
	}

    if(empty($params['id']))
    {
		$smarty->trigger_error("tag_get_count: missing 'id' parameter");
	}

    $count = BeanFactory::newBean('tag_Tags')->getStoredTagCount($params['module'], $params['id']);

    $display = '';

    if ($count == '0')
    {
        $display = '';
    }
    else if ($count == '1')
    {
        $display = "{$count} Tag";
    }
    else
    {
        $display = "{$count} Tags";
    }

    $smarty->assign('tag_count', $display);
}

?>