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

    $moduleMessage = $taggerObj->log_prefix . "Module: {$module}";
    if (!$silent) echo $moduleMessage . "<br>\r\n";
    $GLOBALS['log']->info($moduleMessage);

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

    $tagObj = BeanFactory::newBean('tag_Tags');
    $order_by = "{$moduleObj->get_custom_table_name()}.{$tagObj->tag_modified_field} ASC";

    $sql = $moduleObj->create_new_list_query($order_by, $where, array('id'), array(), false);
    $count_sql = $moduleObj->create_list_count_query($sql);

    $sqlMessage = $taggerObj->log_prefix . "SQL: {$sql}";
    if (!$silent) echo $sqlMessage . "<br>\r\n";
    $GLOBALS['log']->info($sqlMessage);

    $db = DBManagerFactory::getInstance();

    $resultCount = (int)$db->getOne($count_sql);
    $result = $db->limitQuery($sql, 0, $limit);

    if ($resultCount == 0)
    {
        $resultsMessage = $taggerObj->log_prefix . "No results found.";
        if (!$silent) echo $resultsMessage . "<br>\r\n";
        $GLOBALS['log']->info($resultsMessage);
    }
    else
    {
        $resultsMessage = $taggerObj->log_prefix . "{$resultCount} result(s) found but limited to {$limit}.";
        if (!$silent) echo $resultsMessage . "<br>\r\n";
        $GLOBALS['log']->info($resultsMessage);

        while($row = $db->fetchByAssoc($result) )
        {
            $savingMessage = $taggerObj->log_prefix . "Saving {$moduleObj->module_name} / " . $row['id'];
            if (!$silent) echo $savingMessage . "<br>\r\n";
            $GLOBALS['log']->info($savingMessage);

            //process tags for the record
            $bean = BeanFactory::getBean($module, $row['id']);
            BeanFactory::newBean('tag_Tags')->processTags($bean);
        }
    }

    $endMessage = $taggerObj->log_prefix . "End Auto-Tag.";
    if (!$silent) echo $endMessage . "<br>\r\n";
    $GLOBALS['log']->info($endMessage);

?>