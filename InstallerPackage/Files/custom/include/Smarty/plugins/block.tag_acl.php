<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Smarty {tag_acl access="edit"}{/tag_acl} block plugin
 * {tag_acl access="Restricted"}{/tag_acl}
 * Type:     block function<br>
 * Name:     tag_acl<br>
 * Purpose:  Check tag access
 * @param array required_access - required access type for block of text
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return check access for block
 */

function smarty_block_tag_acl($params, $content, Smarty &$smarty)
{
    if (is_null($content))
    {
        return;
    }

    if (empty($params['required_access']))
    {
        $smarty->trigger_error("tag_acl: missing required param (required_access)");
    }

    if (empty($params['module']))
    {
        $smarty->trigger_error("tag_acl: missing required param (module)");
    }

    $required_acls = is_array($params['required_access']) ? $params['required_access'] : preg_split('~\s*,\s*~', $params['required_access']);

    $acl = BeanFactory::newBean('tag_Tags')->getTagUserACL($params['module']);

    if (in_array($acl, $required_acls))
    {
        return $content;
    }

    return;
}

