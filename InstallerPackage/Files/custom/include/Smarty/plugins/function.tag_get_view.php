<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Smarty plugin to retrieve the current view
 */

function smarty_function_tag_get_view($params, &$smarty)
{
    if(empty($_REQUEST['action']))
    {
        $smarty->trigger_error("tag_get_view: missing 'action' in request");
    }

    if(empty($_REQUEST['module']))
    {
        $smarty->trigger_error("tag_get_view: missing 'module' in request");
    }

    $smarty->assign('view_module', $_REQUEST['module']);
    $smarty->assign('view_action', $_REQUEST['action']);

    if ( (isset($_REQUEST['subpanel']) && !empty($_REQUEST['subpanel'])) || (isset($_REQUEST['forQuickCreate']) && $_REQUEST['forQuickCreate'] == 1))
    {
        $smarty->assign('subpanel', '1');
    }
}

?>