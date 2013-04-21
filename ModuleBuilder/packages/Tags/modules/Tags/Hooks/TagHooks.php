<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TagHooks
{
    /**
     * Populates tags for a bean for display on DetailView, EditView, and ListView
     *
     * @param $bean
     * @param $event
     * @param $arguments
     */
    function PopulateTags($bean, $event, $arguments)
    {
        //removing but leaving function for backward compatibility
        //BeanFactory::newBean('tag_Tags')->setBeanTags($bean);
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
