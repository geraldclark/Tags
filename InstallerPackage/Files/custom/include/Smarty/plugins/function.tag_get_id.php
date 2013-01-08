<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
* Smarty plugin to create an id - used for listview element ids since the same record can be displayed twice.
*/

function smarty_function_tag_get_id($params, &$smarty)
{
    require_once('include/utils.php');
    return create_guid();
}

?>