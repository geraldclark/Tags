<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
* Smarty plugin to retrieve the search form a tag field is located on
*/

function smarty_function_tag_get_search_layout($params, &$smarty)
{
    if(empty($params['module']))
    {
		$smarty->trigger_error("tag_get_search_layout: missing 'module' parameter");
	}

    if(empty($params['field']))
    {
		$smarty->trigger_error("tag_get_search_layout: missing 'field' parameter");
	}

    require_once('modules/tag_Tags/Helpers/FieldHelper.php');
    $fieldHelperObj = new FieldHelper();
    $formName = $fieldHelperObj->locateSearchDefs($params['field'], $params['module']);

    if ($formName === false)
    {
        $formName = '';
    }

    //remove _search postfix for field name
    $formNameShort = str_replace("_search", "", $formName);

    //assign vars
    $smarty->assign('tagSearchForm', $formName);
    $smarty->assign('tagSearchFormShort', $formNameShort);
}

?>