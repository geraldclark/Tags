<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
* Smarty plugin to setup modules to fields for tagger
*/

function smarty_function_tag_get_modules_fields($params, &$smarty)
{

    $tagObj = BeanFactory::newBean("tag_Tags");
    $modules = $tagObj->getInstalledModules();
    $modules[''] = "";
    asort($modules);

    $fields = array();

    //hack for subpanel on tags
    if (
        isset($_REQUEST['action'])
        && $_REQUEST['action'] == 'SubpanelCreates'
        && isset($_REQUEST['parent_type'])
        && $_REQUEST['parent_type'] == 'tag_Tags'
        && isset($_REQUEST['parent_id'])
        && !empty($_REQUEST['parent_id'])
       )
    {
        $params['module'] = BeanFactory::getBean($_REQUEST['parent_type'], $_REQUEST['parent_id'])->target_module;
    }

    //hack for subpanel full form redirect on tags
    if (
        isset($_REQUEST['relate_to'])
        && $_REQUEST['relate_to'] == 'tag_taggers_tag_tags'
        && isset($_REQUEST['return_module'])
        && $_REQUEST['return_module'] == 'tag_Tags'
        && isset($_REQUEST['relate_id'])
        && !empty($_REQUEST['relate_id'])
       )
    {
        $params['module'] = BeanFactory::getBean($_REQUEST['return_module'], $_REQUEST['relate_id'])->target_module;
    }

    if(!empty($params['module']) && isset($modules[$params['module']]))
    {
        $modulesTemp = array();
        $modulesTemp[$params['module']] = $modules[$params['module']];
        $modules = $modulesTemp;
	}

    if(!empty($params['fields']))
    {
        $fields = unserialize(base64_decode($params['fields']));
        $smarty->assign('selectFields', 'updateFields("'.$params['module'].'", ' . json_encode($fields) .');');
    }
    else
    {
        $smarty->assign('selectFields', 'updateFields("'.$params['module'].'", "");');
    }

    $smarty->assign('modules', $modules);

    $taggerObj = BeanFactory::newBean('tag_Taggers');
    foreach ($modules as $key=>$label)
    {
        $modulesFields[$key]['label'] = $label;
        $modulesFields[$key]['fields'] = $taggerObj->getFilteredFields($key);
    }

    $smarty->assign('modulesFields', json_encode($modulesFields));
    $smarty->assign('selectedFieldString', implode(", ", $fields));
}

?>