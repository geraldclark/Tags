<?php

	if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	class TaggerHooks
	{
        /**
         * Prevents a user from associating tags to a tagger that arnt the same module type
         *
         * @param $bean
         * @param $event
         * @param $arguments
         * @return mixed
         */
        function ForceRelationshipRestrictions(&$bean, $event, $arguments)
		{

            if (
                isset($arguments['id'])
                && !empty($arguments['id'])
                && isset($arguments['related_id'])
                && !empty($arguments['related_id'])
                && isset($arguments['module'])
                && !empty($arguments['module'])
                && isset($arguments['related_module'])
                && !empty($arguments['related_module'])
                && isset($arguments['relationship'])
                && $arguments['relationship'] == 'tag_taggers_tag_tags'
               )
            {
                if (
                    $arguments['module'] == 'tag_Taggers'
                    && $arguments['related_module'] == 'tag_Tags'
                   )
                {
                    $taggerObj = BeanFactory::getBean('tag_Taggers', $arguments['id']);
                    $tagObj = BeanFactory::getBean('tag_Tags', $arguments['related_id']);
                }
                else
                {
                    $tagObj = BeanFactory::getBean('tag_Taggers', $arguments['related_id']);
                    $taggerObj = BeanFactory::getBean('tag_Tags', $arguments['id']);
                }

                if(empty($taggerObj->tag_taggers_tag_tags) && !$taggerObj->load_relationship('tag_taggers_tag_tags'))
                {
                    return;
                }

                if ($tagObj->target_module != $taggerObj->monitored_module)
                {
                    $GLOBALS['log']->fatal($taggerObj->log_prefix . "Removing association :: Tag '$tagObj->id' does not belong to tagger '{$taggerObj->id}'. Module mismatch {$tagObj->target_module} / {$taggerObj->monitored_module}.");
                    $taggerObj->tag_taggers_tag_tags->delete($taggerObj->id, $tagObj->id);
                }
            }
		}
	}

?>
