<?php 

/**
 * Builds the list of modules with tag relationships
 * @return array
 */
function tag_getInstalledModules()
{
    $tagObj = BeanFactory::newBean("tag_Tags");
    $list = $tagObj->getInstalledModules();

    $module = "";
    //hack for subpanel on taggers
    if (
        isset($_REQUEST['action'])
        && $_REQUEST['action'] == 'SubpanelCreates'
        && isset($_REQUEST['target_module'])
        && $_REQUEST['target_module'] == 'tag_Tags'
        && isset($_REQUEST['parent_type'])
        && $_REQUEST['parent_type'] == 'tag_Taggers'
        && isset($_REQUEST['parent_id'])
        && !empty($_REQUEST['parent_id'])
       )
    {
        $module = BeanFactory::getBean($_REQUEST['parent_type'], $_REQUEST['parent_id'])->monitored_module;
    }
    //hack for subpanel full form redirect on taggers
    elseif (
        isset($_REQUEST['relate_to'])
        && $_REQUEST['relate_to'] == 'tag_taggers_tag_tags'
        && isset($_REQUEST['module'])
        && $_REQUEST['module'] == 'tag_Tags'
        && isset($_REQUEST['return_module'])
        && $_REQUEST['return_module'] == 'tag_Taggers'
        && isset($_REQUEST['relate_id'])
        && !empty($_REQUEST['relate_id'])
       )
    {
        $module = BeanFactory::getBean($_REQUEST['return_module'], $_REQUEST['relate_id'])->monitored_module;
    }

    if (!empty($module) && isset($list[$module]))
    {
        $listTemp[$module] = $list[$module];
        $list = $listTemp;
    }
    else
    {
        $list[''] = "";
        asort($list);
    }

    return $list;
}
?>