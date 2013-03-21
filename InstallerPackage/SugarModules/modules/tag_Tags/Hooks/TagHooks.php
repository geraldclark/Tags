<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TagHooks
{
    /**
     * Populates tags for a bean for DetailView, EditView, ListView and Subpanels
     *
     * @param $bean
     * @param $event
     * @param $arguments
     */
    function PopulateTags($bean, $event, $arguments)
    {
        BeanFactory::newBean('tag_Tags')->setBeanTags($bean);
    }

    /**
     * Handles the save logic between normal user saves and tagger logic
     *
     * @param $bean
     * @param $event
     * @param $arguments
     */
    function SaveTags($bean, $event, $arguments)
    {
        BeanFactory::newBean('tag_Tags')->processTags($bean);
    }
}

?>
