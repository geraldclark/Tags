<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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
        $days = 0;
    }

    $taggerObj = BeanFactory::newBean('tag_Taggers');

    if (!$taggerObj->isTaggerEnabled($module))
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

    $whereDateSQL = '';

    if ($days !== -1)
    {
        $db = DBManagerFactory::getInstance();
        $todaySQL = $db->convert("", 'today');

        $params = array();
        $params[0] = "-{$days}";
        $params[1] = "DAY";

        $whereDateSQL = $db->convert($todaySQL, 'add_date', $params);
    }

    $moduleObj = BeanFactory::newBean($module);
    if (!is_object($moduleObj)) return false;

    $where = '';

    if (!empty($whereDateSQL))
    {
        $where = "{$moduleObj->table_name}.date_entered >= {$whereDateSQL}";
    }

    $results = BeanFactory::newBean($module)->get_list("{$moduleObj->table_name}.date_modified ASC", $where, 0, $limit, $limit);
    $results = $results["list"];

    foreach ($results as $bean)
    {
        $savingMessage = $taggerObj->log_prefix . "Saving {$moduleObj->module_name} / {$bean->id}";
        if (!$silent) echo $savingMessage . "<br>\r\n";
        $GLOBALS['log']->info($savingMessage);

        $bean->save();
    }

    $endMessage = $taggerObj->log_prefix . "End Auto-Tag.";
    if (!$silent) echo $endMessage . "<br>\r\n";
    $GLOBALS['log']->info($endMessage);

?>