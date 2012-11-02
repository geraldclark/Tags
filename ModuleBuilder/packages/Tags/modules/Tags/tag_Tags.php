<?PHP
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2012 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/

require_once('modules/tag_Tags/tag_Tags_sugar.php');

class tag_Tags extends tag_Tags_sugar
{
    var $log_prefix = 'Tag :: ';
    var $tag_field = 'tag_tags_c';

    function tag_Tags()
    {
        parent::tag_Tags_sugar();
    }

    /**
     * Function fetches a single row of data given the primary key value.
     *
     * @param string $id Optional, default -1, is set to -1 id value from the bean is used, else, passed value is used
     * @param boolean $encode Optional, default true, encodes the values fetched from the database.
     * @param boolean $deleted Optional, default true, if set to false deleted filter will not be added.
     */
    function retrieve($id = -1, $encode=true, $deleted=true)
    {
        $bean = parent::retrieve($id, $encode, $deleted);
        return $bean;
    }

    /**
     * Saves the tag record
     *
     * @param boolean $check_notify Optional, default false, if set to true assignee of the record is notified via email.
     */
    function save($check_notify = FALSE)
    {
        $this->checkHooks($this->target_module);

        //replace double quotes
        $this->name = str_replace('"', '', $this->name);
        $this->name = str_replace('&quot;', '', $this->name);

        //format name
        $this->name = trim($this->name);
        $this->name_upper = strtoupper($this->name);

        $id = parent::save($check_notify);
        return $id;
    }

    /**
     * Retrieves the list of modules that have had relationships installed
     */
    public function getUninstalledModules()
    {
        $availableModules = $this->getAvailableModules();
        $installedModules = $this->getInstalledModules();

        foreach ($installedModules as $key=>$module)
        {
            if (isset($availableModules[$key]))
            {
                unset($availableModules[$key]);
            }
        }

        asort($availableModules);
        return $availableModules;
    }

    /**
     * Checks to see if there are available installed modules
     */
    public function hasInstalledModules()
    {
        if ( count($this->getInstalledModules()) > 0 )
        {
            return true;
        }

        return false;
    }

    /**
     * Retrieves the list of modules that have had relationships installed
     */
    public function getInstalledModules()
    {
        $availableModules = $this->getAvailableModules();
        $configuratorObj = $this->getConfig();

        $installedModules = array();
        if (isset($configuratorObj->config['customTagSettings']['relationships']) && is_array($configuratorObj->config['customTagSettings']['relationships']))
        {
            foreach ($configuratorObj->config['customTagSettings']['relationships'] as $key=>$relationship)
            {
                if (isset($availableModules[$key]) && $this->checkRelationships($key))
                {
                    $installedModules[$key] = $availableModules[$key];
                }
            }
        }

        asort($installedModules);
        return $installedModules;
    }

    /**
     * Retrieve the available modules that tags can be associated to
     */
    public function getAvailableModules()
    {
        global $app_list_strings;

        $invalidModules = array(
            'tag_Taggers',
            'tag_Phrases',
            'tag_Tags',
            'Home',
            'Emails',
            'Calendar',
            'Currencies',
            'Contracts',
            'ProductCategories',
            'ProductTypes',
            'ProductTemplates',
            'Reports',
            'Reports_1',
            'Forecasts',
            'ForecastSchedule',
            'MergeRecords',
            'Quotas',
            'Teams',
            'TeamNotices',
            'Manufacturers',
            'Activities',
            'Feeds',
            'iFrames',
            'TimePeriods',
            'TaxRates',
            'ContractTypes',
            'Schedulers',
            'CampaignLog',
            'DocumentRevisions',
            'Connectors',
            'Roles',
            'Notifications',
            'Sync',
            'ReportMaker',
            'DataSets',
            'CustomQueries',
            'WorkFlow',
            'EAPM',
            'Employees',
            'Administration',
            'ACLRoles',
            'InboundEmail',
            'Releases',
            'Prospects',
            'Queues',
            'EmailMarketing',
            'EmailTemplates',
            'SNIP',
            'ProspectLists',
            'SavedSearch',
            'UpgradeWizard',
            'Trackers',
            'TrackerPerfs',
            'TrackerSessions',
            'TrackerQueries',
            'FAQ',
            'Newsletters',
            'SugarFeed',
            'SugarFavorites',
            'OAuthKeys',
            'OAuthTokens',
            'Library',
            'EmailAddresses',
            'Sugar_Favorites',
        );

        $modules = array();

        //build list
        foreach($app_list_strings['moduleList'] as $key=>$module)
        {
            $modules[$key] = $module;
        }

        //remove invalid modules
        foreach ($invalidModules as $invalidModule)
        {
            if (isset($modules[$invalidModule]))
            {
                unset($modules[$invalidModule]);
            }
        }

        asort($modules);
        return $modules;
    }

    /**
     * Retrieves the user ACL for tags
     *
     * @return string - possible values are 'Editable', 'Limited' and 'Restricted'
     */
    public function getTagUserACL()
    {
        $configuratorObj = $this->getConfig();

        $possibleValues = array('Editable', 'Limited', 'Restricted');
        $taggerObj = BeanFactory::newBean('tag_Taggers');
        if ($taggerObj->getTaggerBehavior() == 'Reevaluate' && $taggerObj->isTaggerEnabled())
        {
            return 'Restricted';
        }
        elseif (isset($configuratorObj->config['customTagSettings']['tag']['acl']) && in_array($configuratorObj->config['customTagSettings']['tag']['acl'], $possibleValues))
        {
            return $configuratorObj->config['customTagSettings']['tag']['acl'];
        }

        //return editable as the default setting
        return 'Editable';
    }

    /**
     * Retrieves the config and sets any defaults we may be missing.
     *
     * @return object $configuratorObj - system config
     */
    public function getConfig()
    {

        require_once 'modules/Configurator/Configurator.php';
        $configuratorObj = new Configurator();
        $configuratorObj->loadConfig();

        $configStart = $configuratorObj->config;

        if (!isset($configuratorObj->config['customTagSettings']))
        {
            $configuratorObj->config['customTagSettings'] = array();
        }

        if (!isset($configuratorObj->config['customTagSettings']['tagger']['session']))
        {
            $configuratorObj->config['customTagSettings']['tagger']['session'] = 'Inactive';
        }

        if (!isset($configuratorObj->config['customTagSettings']['tagger']['status']))
        {
            $configuratorObj->config['customTagSettings']['tagger']['status'] = 'Inactive';
        }

        if (!isset($configuratorObj->config['customTagSettings']['tagger']['behavior']))
        {
            $configuratorObj->config['customTagSettings']['tagger']['behavior'] = 'Append';
        }

        if (!isset($configuratorObj->config['customTagSettings']['tagger']['limit']))
        {
            $configuratorObj->config['customTagSettings']['tagger']['limit'] = '200';
        }

        if (!isset($configuratorObj->config['customTagSettings']['tagger']['days']))
        {
            $configuratorObj->config['customTagSettings']['tagger']['days'] = '-1';
        }

        if (!isset($configuratorObj->config['customTagSettings']['tag']['acl']))
        {
            $configuratorObj->config['customTagSettings']['tag']['acl'] = 'Editable';
        }

        if ($configStart !== $configuratorObj->config)
        {
            $GLOBALS['log']->info($this->log_prefix . "Updating config settings.");
            $configuratorObj->saveConfig();
        }

        $configuratorObj->loadConfig();

        return $configuratorObj;
    }

    /**
     * Checks to make sure the tag field has a definition in custom/modules/module/metadata/SearchFields.php. If not, one is added.
     */
    function addSearchField($module)
    {
        if (empty($module))
        {
            return;
        }

        require_once('modules/tag_Tags/Helpers/FieldHelper.php');
        $fieldHelp = new FieldHelper();

        if ($fieldHelp->checkForSearchField($module, $this->tag_field))
        {
            return;
        }

        $moduleObj = BeanFactory::newBean($module);

        //handle broken modules
        if (!is_object($moduleObj))
        {
            return;
        }

        $relationshipName = $this->loadBeanRelationshipToTags($moduleObj);

        if ($relationshipName === false)
        {
            $GLOBALS['log']->fatal($this->log_prefix . "Check search field for '{$module}' did not find a relationship.");
            return;
        }

        $join = $moduleObj->$relationshipName->getJoin(array());

        $subquery = str_replace("\n"," ", "SELECT {$moduleObj->table_name}.id FROM {$moduleObj->table_name} {$join} WHERE {$moduleObj->table_name}.deleted = 0 AND tag_tags.name in ({0})");

        //add search defs
        $definition = array (
            'query_type' => 'format',
            'operator' => 'subquery',
            'subquery' => $subquery,
            'db_field' => array (
                'id',
            ),
        );

        $fieldHelp->addSearchField($module, $this->tag_field, $definition);
    }

    /**
     * Runs all repairs needed after a relationship is installed.
     *   -Used so we can install multiple relationships and only run 1 repair.
     */
    function runRepairs()
    {
        require_once('modules/tag_Tags/Helpers/RelationshipHelper.php');
        $relHelper = new RelationshipHelper('tag_Tags');
        $relHelper->runRepairs();
    }

    /**
     * Make sure all relationships are setup correctly
     */
    function runRelationshipChecks()
    {
        //go through all uninstalled modules and make sure the rels werent taken out of the config.
        $uninstalledModules = $this->getAvailableModules();

        foreach ($uninstalledModules as $uninstalledModule)
        {
            $this->checkRelationships($uninstalledModule);
        }

        //go through all installed modules and make sure the field was added to search fields.
        $installedModules = $this->getInstalledModules();

        foreach ($installedModules as $installedModule)
        {
            $this->addSearchField($installedModule);
            $this->checkHooks($installedModule);
        }
    }

    /**
     * @param string $module - module to install relationship to
     * @param bool $runRepair - if we are installing multiple relationships, set to false so we only run 1 repair afterward.
     */
    function installRelationship($module, $runRepair = true)
    {
        $GLOBALS['log']->info($this->log_prefix . "Creating relationship between {$module} and tag_Tags.");

        //create relationship
        require_once('modules/tag_Tags/Helpers/RelationshipHelper.php');
        $relHelper = new RelationshipHelper('tag_Tags');

        $savePath = 'custom/modules/tag_Tags/builds';
        $relDef = $relHelper->setupRelationshipDefinition($module, 'many-to-many');
        $relName = $relHelper->setupRelationshipName($relDef);

        $installDefs = array();
        $installDefs['relationships'] = $relHelper->createRelationshipMetaData($relDef, $relName, $savePath);

        //create tagger field
        $vardefs = array();
        $vardefs[$module][] = array(
            'name' => $this->tag_field,
            'type' => 'CustomTag',
            'source' => 'non-db',
            'dbType' => 'non-db',
            'studio' => 'visible',
            'vname' => 'LBL_' . strtoupper($this->tag_field),
            'module' => $module,
            'audited' => false,
            'sortable' => false,
        );

        //add fields for M-M
        $vardefs = $relHelper->setupVardefManyToMany($module, $relName, $vardefs);

        //create vardefs
        $installDefs['vardefs'] = $relHelper->createVardefs($vardefs, $relName, $savePath);

        $labels = array();
        $labels[]= $relHelper->setupLabel('LBL_' . strtoupper($this->tag_field), 'Tags', $module);
        $labels = $relHelper->setupLabelsForManyToMany($module, $relName, $labels);

        $installDefs['language'] = $relHelper->createLabels($labels, $relName , $savePath);

        //add tags field
        $installDefs['layoutfields'] = array(
            array(
                'additional_fields' => array(
                    $module => $this->tag_field,
                ),
            ),
        );

        //install everything
        $relHelper->installRelationship($relName, $installDefs, $savePath, $runRepair);

        //set relationship name in config
        $configuratorObj = $this->getConfig();
        $configuratorObj->config['customTagSettings']['relationships'][$module] = $relName;
        $configuratorObj->saveConfig();

        if ($runRepair)
        {
            $this->addSearchField($module);
        }

        $GLOBALS['log']->info($this->log_prefix . "Relationship '{$relName}' created.");
    }

    /**
     * Checks to make sure a relationship exists between the tag and selected bean.
     */
    function checkRelationships($module)
    {
        if (empty($module))
        {
            return;
        }

        $configuratorObj = $this->getConfig();
        $configStart = $configuratorObj->config;

        $db = DBManagerFactory::getInstance();

        require_once('modules/Relationships/Relationship.php');
        $relationshipObj = new Relationship();

        $relationshipExists = false;

        if (
            !empty($module)
            && isset($configuratorObj->config['customTagSettings']['relationships'][$module])
            && !empty($configuratorObj->config['customTagSettings']['relationships'][$module])
        )
        {
            $relationshipExists = $relationshipObj->exists($configuratorObj->config['customTagSettings']['relationships'][$module], $db);
        }

        if (!$relationshipExists)
        {
            $potentialRelationship = $relationshipObj->retrieve_by_modules('tag_Tags', $module, $db, 'many-to-many');

            if ($potentialRelationship === null)
            {
                $configuratorObj->config['customTagSettings']['relationships'][$module] = "";
                $configuratorObj->saveConfig();
                return false;
            }
            else
            {
                $GLOBALS['log']->info($this->log_prefix . "Updating config settings to use potential relationship '{$potentialRelationship}'.");

                //update the config to use the found relationship
                $configuratorObj->config['customTagSettings']['relationships'][$module] = $potentialRelationship;
                $configuratorObj->saveConfig();
                return true;
            }
        }
        else
        {
            return true;
        }

    }

    /**
     * Checks to make sure that the needed logic hooks are in place
     *  - after_save - for saving tags to beans
     *  - after_retrieve - for populating on EditView and DetailView
     *  - process_record - for populating ListView and Subpanels
     */
    function checkHooks($module)
    {
        if (!empty($module))
        {
            require_once("include/utils.php");

            //handle tag save logic
            $hook = Array(99999, 'Add Selected Tags For New Records', 'modules/tag_Tags/Hooks/TagHooks.php', 'TagHooks', 'SaveTags');
            check_logic_hook_file($module, "after_save", $hook);

            //add tags to editview and detailview
            $hook = Array(99999, 'Populate Tags Field', 'modules/tag_Tags/Hooks/TagHooks.php', 'TagHooks', 'PopulateTags');
            check_logic_hook_file($module, "after_retrieve", $hook);

            //add tags to listview
            $hook = Array(99999, 'Populate Tags Field', 'modules/tag_Tags/Hooks/TagHooks.php', 'TagHooks', 'PopulateTags');
            check_logic_hook_file($module, "process_record", $hook);
        }
    }

    /**
     * Converts a string of tags into an array
     *
     * @param string $tagString - csv string or multiselect string
     * @return array $tagArray - array containing the tag ids
     */
    function tagStringToArray($tagString)
    {
        if (is_array($tagString))
        {
            return $tagString;
        }
        //try to determine is multiselect string
        elseif ((substr($tagString, 0 ,1) == "^" && substr($tagString, -1) == "^"))
        {
            require_once('include/utils.php');
            $tagArray = unencodeMultienum($tagString);
        }
        //else assume a csv string
        else
        {
            $tagArray = explode(",", $tagString);
        }

        foreach ($tagArray as $id=>$tag)
        {
            if (empty($tag))
            {
                unset($tagArray[$id]);
            }
            else
            {
                $tagArray[$id] = trim($tag);
            }
        }

        return $tagArray;
    }

    /**
     * Checks tag ACL when adding tags so we can prevent adding tags when needed
     *
     * @param array $tagNames - array of tag names
     * @param string $module - module to filter search by
     * @return array $tagIds - array of found ids
     */
    function getTagIdsFromNamesACL($tagNames, $module)
    {
        $tagIds = array();

        if ($this->getTagUserACL() == 'Editable')
        {
            $tagIds = $this->getTagIdsFromNames($tagNames, $module);
        }
        else
        {
            $tagIds = $this->getTagIdsFromNames($tagNames, $module, false);
        }

        return $tagIds;
    }

    /**
     * Finds the difference between two arrays so we can figure out which tags to add
     *
     * @param array $selectedTagIds - array of selected tag id
     * @param array $currentTagIds - array of current tags to get diff from
     * @param object $bean - Bean to add tags to
     */
    function addTagDifference($selectedTagIds, $currentTagIds, &$bean)
    {
        //figure out which keys to add
        $addTags = array();
        foreach($selectedTagIds as $key=>$value)
        {
            if (!isset($currentTagIds[$key]))
            {
                $addTags[]=$value;
            }
        }

        $GLOBALS['log']->info($this->log_prefix . "Adding Tags: " . implode(", ", $addTags));
        $this->addTagsToBean($bean, $addTags);
    }

    /**
     * Finds the difference between two arrays so we can figure out which tags to remove
     *
     * @param array $selectedTagIds - array of selected tag id
     * @param array $currentTagIds - array of current tags to get diff from
     * @param object $bean - Bean to add tags to
     */
    function removeTagDifference($selectedTagIds, $currentTagIds, &$bean)
    {
        $removeTags = array();
        foreach($currentTagIds as $key=>$value)
        {
            if (!isset($selectedTagIds[$key]))
            {
                $removeTags[]=$value;
            }
        }

        $GLOBALS['log']->info($this->log_prefix . "Removing Tags: " . implode(", ", $removeTags));
        $this->removeTagsFromBean($bean, $removeTags);
    }

    /**
     * Takes the current tag values from user input and updates the current selection
     *   - disabled tags are excluded from modification if the user ACL is 'Limited'
     *
     * @param $bean - bean to update tags for
     */
    public function saveBeanTags(&$bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Start tag save logic.'");

        if ($this->getTagUserACL() != 'Restricted')
        {
            $tagNames = $this->tagStringToArray($bean->{$this->tag_field});

            $selectedTagIds = $this->getTagIdsFromNamesACL($tagNames, $bean->module_name);

            //get current tags
            $currentTagIds = $this->getBeanTagIds($bean);

            //add tag difference
            $this->addTagDifference($selectedTagIds, $currentTagIds, $bean);

            //remove tag difference
            $this->removeTagDifference($selectedTagIds, $currentTagIds, $bean);
        }

        $GLOBALS['log']->info($this->log_prefix . "End tag save logic.'");
    }

    /**
     * Matches tag criteria from a tagger setup
     *
     * @param $bean - bean to update tags for
     */
    public function saveTaggerTags(&$bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Start tagger save logic.'");

        $taggerObj = BeanFactory::newBean('tag_Taggers');

        //return if tagger is disabled
        if (!$taggerObj->isTaggerEnabled())
        {
            return;
        }

        $GLOBALS['log']->info($this->log_prefix . "Finding matches for {$bean->module_name}.");

        $results = $taggerObj->get_full_list('', " tag_taggers.status = 'Active' AND tag_taggers.monitored_module = '{$bean->module_name}' ");

        if ($taggerObj->getTaggerBehavior() == 'Reevaluate')
        {
            //get current tags unfiltered
            $currentTagIds = $this->getBeanTagIds($bean);
            //start with nothing
            $selectedTagIds = array();
        }
        else
        {
            //get current tags filtered
            $currentTagIds = $this->getBeanTagIds($bean, true);
            //start with all current tags
            $selectedTagIds = $currentTagIds;
        }

        if (!empty($results))
        {
            foreach ($results as $taggerObj)
            {
                $GLOBALS['log']->info($this->log_prefix . "Checking matches for {$taggerObj->id} / {$taggerObj->name}.");

                $matches = $taggerObj->findMatches($bean, $selectedTagIds);

                if ($matches !== false)
                {
                    foreach ($matches as $tagIdKey=>$tagIdValue)
                    {
                        $selectedTagIds[$tagIdKey] = $tagIdValue;
                    }
                }
            }
        }

        //add tag difference
        $this->addTagDifference($selectedTagIds, $currentTagIds, $bean);

        if (BeanFactory::newBean('tag_Taggers')->getTaggerBehavior() == 'Reevaluate')
        {
            //remove tag difference
            $this->removeTagDifference($selectedTagIds, $currentTagIds, $bean);
        }

        //make sure we reset the bean tag field
        $this->setBeanTags($bean);

        $GLOBALS['log']->info($this->log_prefix . "End tagger save logic.'");
    }

    /**
     * Adds tags to a bean by tag name instead of ID
     *
     * @param object $bean - bean to update tags for
     * @param string/array $tags - csv string or multiselect string will be converted to an array
     * @return array $tagIds - array containing the tag ids
     */
    public function addTagsToBeanByName(&$bean, $tags)
    {
        if (is_array($tags))
        {
            $tagArray = $tags;
        }
        elseif(is_string($tags))
        {
            $tagArray = $this->tagStringToArray($tags);
        }
        else
        {
            return false;
        }

        $tagIds = array();

        if ($this->getTagUserACL() == 'Editable')
        {
            $tagIds = $this->getTagIdsFromNames($tagArray, $bean->module_name);
        }
        else
        {
            $tagIds = $this->getTagIdsFromNames($tagArray, $bean->module_name, false);
        }

        if (!empty($tagIds))
        {
            $this->addTagsToBean($bean, $tagIds);
        }

        return $tagIds;
    }

    /**
     * Looks up a tag ID by module and name
     *
     * @param array $tagNames - array of tag names
     * @param string $module - target module of tags
     * @opt_param boolean $createNew - creates a new tag if one doesnt exist. Defaults to true
     * @return array $tagIds - array containing the added tag ids
     */
    function getTagIdsFromNames($tagNames, $module, $createNew = true)
    {
        $tagIds = array();

        $tagNames = $this->tagStringToArray($tagNames);
        $tagNamesOriginal = $tagNames;

        $db = DBManagerFactory::getInstance();

        $searchTags = array();

        foreach ($tagNames as $key=>$value)
        {
            $searchTags[] = $db->quoted(strtoupper($value));
            $tagNames[$key] = strtoupper($value);
        }

        if (count($searchTags) == 0)
        {
            return array();
        }

        $searchString = "(" . implode(",", $searchTags) . ")";

        $results = $this->get_full_list('', " tag_tags.target_module = '{$module}' AND tag_tags.name_upper in {$searchString} ");

        if (!empty($results))
        {
            foreach ($results as $tagObj)
            {
                $tagIds[$tagObj->id] = $tagObj->id;

                if ($createNew)
                {
                    $key = array_search(strtoupper($tagObj->name), $tagNames);
                    unset($tagNamesOriginal[$key]);
                }
            }
        }

        if ($createNew)
        {
            foreach ($tagNamesOriginal as $tag)
            {
                if (!empty($module) && !empty($tag))
                {
                    $GLOBALS['log']->info($this->log_prefix . "Creating  tag '{$tag}'.");
                    $newTag = BeanFactory::newBean($this->module_name);
                    $newTag->name = $tag;
                    $newTag->target_module = $module;
                    $newTag->save();
                    $tagIds[$newTag->id] = $newTag->id;
                }
            }
        }

        return $tagIds;
    }

    /**
     * Retrieves all current tags for a selected module
     *   - disabled tags are excluded from results if user ACL is 'Restricted' or 'Limited'
     *
     * @param string $module - key of module to retrieve tags for
     */
    function getModuleTags($module)
    {
        $GLOBALS['log']->info($this->log_prefix . "Retrieving tags for module '{$module}'.");

        $filterActive = "";
        if (in_array($this->getTagUserACL(), array("Restricted", "Limited")))
        {
            $filterActive = "AND tag_tags.status = 'Active'";
        }

        $results = $this->get_full_list('tag_tags.name_upper ASC', "tag_tags.target_module = '{$module}' {$filterActive}");

        $tags = array();

        if (!empty($results))
        {
            foreach ($results as $tagObj)
            {
                $tags[strtoupper($tagObj->name_upper)] = $tagObj->name;
            }
        }

        return $tags;
    }

    /* -- The functions below are designed to be generic between beans -- */

    /**
     * Retrieves related tag ids from a selected bean
     *
     * @param object $bean - bean to retrieve related tags from
     * @param bool $filterActive - filters by active status if 'true'
     * @return array $tagIds - list of related tag ids
     */
    public function getBeanTagIds(&$bean, $filterActive = false)
    {
        $tagObjs = $this->getBeanTags($bean, $filterActive);

        $tagIds = array();
        foreach ($tagObjs as $tagObj)
        {
            $tagIds[$tagObj->id] = $tagObj->id;
        }

        $GLOBALS['log']->info($this->log_prefix . "Current Tags: " . implode(", ", $tagIds));

        return $tagIds;
    }

    /**
     * Retrieves related tag beans from a selected bean
     *
     * @param object $bean - bean to retrieve related tags from
     * @param bool $filterActive - filters by active status if 'true'
     * @return array $tagIds - list of related tag objects
     */
    public function getBeanTags(&$bean, $filterActive = false)
    {
        $filter=array();
        if ($filterActive)
        {
            $GLOBALS['log']->info($this->log_prefix . "Filtering tags by 'Active' status");
            $filter=array(
                'where' => array(
                    'lhs_field' => 'status',
                    'operator' => '=',
                    'rhs_value' => 'Active',
                ),
            );
        }

        $relationshipName = $this->loadBeanRelationshipToTags($bean);

        if (!empty($relationshipName))
        {
            return $bean->$relationshipName->getBeans($filter);
        }
        else
        {
            return array();
        }
    }

    /**
     * Retrieves and sets related tags to the tag field on the bean
     *
     * @param object $bean - bean to retrieve retrieve and set tags for display
     */
    public function setBeanTags(&$bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Populating Tags for {$bean->module_name} / {$bean->id}");

        require_once('include/utils.php');

        $relatedTags = array();
        if (in_array($this->getTagUserACL(), array("Restricted", "Limited")))
        {
            $relatedTags = $this->getBeanTags($bean, true);
        }
        else
        {
            $relatedTags = $this->getBeanTags($bean);
        }

        $tags = array();
        foreach ($relatedTags as $relatedTag)
        {
            $tags[strtolower($relatedTag->name)] = $relatedTag->name;
        }

        ksort($tags);
        $bean->{$this->tag_field} = encodeMultienumValue($tags);
    }

    /**
     * Removes tags from a bean by name
     *
     * @param object $bean - bean to retrieve tags from
     * @param array $tagNames - array of tag names
     */
    public function removeTagsFromBeanByName(&$bean, $tagNames)
    {
        $tagNames = $this->tagStringToArray($tagNames);

        $tagIds = $this->getTagIdsFromNames($tagNames, $bean->module_name, false);

        if (!empty($tagIds))
        {
            $this->removeTagsFromBean($bean, $tagIds);
        }
    }

    /**
     * Removes tags from a bean by id
     *
     * @param object $bean - bean to retrieve tags from
     * @param array $tagIds - array of tag ids
     */
    public function removeTagsFromBean(&$bean, $tagIds)
    {
        $relationshipName = $this->loadBeanRelationshipToTags($bean);
        foreach($tagIds as $tagId)
        {
            $bean->$relationshipName->delete($bean->id, $tagId);
        }
    }

    /**
     * Adds tags from a bean by id
     *
     * @param object $bean - bean to retrieve tags from
     * @param array $tagIds - array of tag ids
     */
    public function addTagsToBean(&$bean, $tagIds)
    {
        $relationshipName = $this->loadBeanRelationshipToTags($bean);
        $bean->$relationshipName->add($tagIds);
    }

    /**
     * Loads the tag relationship to a bean
     *
     * @param object $bean - bean to load relationship for
     */
    function loadBeanRelationshipToTags(&$bean)
    {
        $relationshipName = false;

        global $sugar_config;

        if (isset($sugar_config['customTagSettings']['relationships'][$bean->module_name]) && !empty($sugar_config['customTagSettings']['relationships'][$bean->module_name]))
        {
            //relate tags to record
            $relationshipName = $sugar_config['customTagSettings']['relationships'][$bean->module_name];

            if(empty($bean->$relationshipName) && !$bean->load_relationship($relationshipName))
            {
                $GLOBALS['log']->fatal($this->log_prefix . "Could not load the relationship '{$relationshipName}' for {$bean->module_name}.");
                return false;
            }
            return $relationshipName;
        }

        //throw error
        $GLOBALS['log']->fatal($this->log_prefix . "The relationship config setting for {$bean->module_name} is missing! To correct this issue, open and save a tag record for this module.");
        return false;
    }
}

?>