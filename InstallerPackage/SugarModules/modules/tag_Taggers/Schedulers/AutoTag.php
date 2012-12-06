<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('modules/tag_Tags/TagSettings.php');
    $settings = new TagSettings();

    if (!isset($limit))
    {
        $limit = 200;
    }

    if (!isset($silent))
    {
        $silent = true;
    }

    if (!isset($days))
    {
        $days = 0
    }

    $taggerObj = BeanFactory::newBean('tag_Taggers');

    if (!$taggerObj->isTaggerEnabled())
    {
        $exitMessage = $taggerObj->log_prefix . "Auto-Tag is not enabled.";
        if (!$silent) echo $exitMessage . "<br>\r\n";
        $GLOBALS['log']->info($exitMessage);
        //skip job
        return true;
    }


    $startMessage = $taggerObj->log_prefix . "Start Auto-Tag.";
    if (!$silent) echo $startMessage . "<br>\r\n";
    $GLOBALS['log']->info($startMessage);

    $limitMessage = $taggerObj->log_prefix . "Limit: {$limit}";
    if (!$silent) echo $limitMessage . "<br>\r\n";
    $GLOBALS['log']->info($limitMessage);

    $daysMessage = $taggerObj->log_prefix . "Days: {$days}";
    if (!$silent) echo $daysMessage . "<br>\r\n";
    $GLOBALS['log']->info($daysMessage);

    $db = DBManagerFactory::getInstance();
    $sql = "SELECT DISTINCT tag_taggers.monitored_module FROM tag_taggers WHERE tag_taggers.status ='Active' AND tag_taggers.deleted = 0";
    $result = $db->query($sql);

    $modules = array();

    while($row = $db->fetchByAssoc($result) )
    {
        $modules[] = $row['monitored_module'];
    }

    $moduleCount = count($modules);

    $whereDateSQL = '';

    if ($days !== -1)
    {
        $todaySQL = $db->convert("", 'today');

        $params = array();
        $params[0] = "-{$days}";
        $params[1] = "DAY";

        $whereDateSQL = $db->convert($todaySQL, 'add_date', $params);
    }

    if ($moduleCount > 0)
    {
        $limitPerModule = round($limit / $moduleCount, 0);

        //prevent zero
        if ($limitPerModule == 0) $limitPerModule = 1;


        $moduleLimitMessage = $taggerObj->log_prefix . "Limit Per Module: {$limitPerModule}";
        if (!$silent) echo $moduleLimitMessage . "<br>\r\n";
        $GLOBALS['log']->info($moduleLimitMessage);

        foreach ($modules as $module)
        {
            $moduleObj = BeanFactory::newBean($module);
            if (!is_object($moduleObj)) continue;

            $where = '';

            if (!empty($whereDateSQL))
            {
                $where = "{$moduleObj->table_name}.date_entered >= {$whereDateSQL}";
            }

            $results = BeanFactory::newBean($module)->get_list("{$moduleObj->table_name}.date_modified ASC", $where, 0, $limitPerModule, $limitPerModule);
            $results = $results["list"];

            foreach ($results as $bean)
            {
                $savingMessage = $taggerObj->log_prefix . "Saving {$moduleObj->module_name} / {$bean->id}.";
                if (!$silent) echo $savingMessage . "<br>\r\n";
                $GLOBALS['log']->info($savingMessage);

                $bean->save();
            }
        }
    }
    else
    {
        $noModulesMessage = $taggerObj->log_prefix . "No modules found for queue.";
        if (!$silent) echo $noModulesMessage . "<br>\r\n";
        $GLOBALS['log']->info($noModulesMessage);
    }

    $endMessage = $taggerObj->log_prefix . "End Auto-Tag.";
    if (!$silent) echo $endMessage . "<br>\r\n";
    $GLOBALS['log']->info($endMessage);

?>