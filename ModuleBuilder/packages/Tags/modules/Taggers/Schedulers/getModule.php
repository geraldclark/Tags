<?php

$tagObj = BeanFactory::newBean('tag_Tags');
$installedModules = $tagObj->getInstalledModules();

$oldestRun = null;
$module = '';
foreach ($installedModules as $moduleKey=>$moduleName)
{
    $taggerObj = BeanFactory::newBean('tag_Taggers');
    if ($taggerObj->isTaggerEnabled($moduleKey))
    {
        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($moduleKey);

        if ($oldestRun == null)
        {
            $oldestRun = $settings->scheduler_last_run->value;
            $module = $moduleKey;
        }
        else
        {
            if (strtotime($oldestRun) > strtotime($settings->scheduler_last_run->value))
            {
                $oldestRun = $settings->scheduler_last_run->value;
                $module = $moduleKey;
            }
        }
    }
}

?>