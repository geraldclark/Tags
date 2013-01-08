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
        function PopulateTags(&$bean, $event, $arguments)
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
        function SaveTags(&$bean, $event, $arguments)
        {
            $tagObj = BeanFactory::newBean('tag_Tags');
            $taggerObj = BeanFactory::newBean('tag_Taggers');

            if ($taggerObj->isTaggerEnabled($bean->module_name) && $taggerObj->getTaggerBehavior($bean->module_name) == 'Reevaluate')
            {
                //only run the tagger since it'll remove any non-matching tags anyway
                $tagObj->saveTaggerTags($bean);
            }
            else
            {
                //run both
                $tagObj->saveBeanTags($bean);
                $tagObj->saveTaggerTags($bean);
            }
        }
	}

?>
