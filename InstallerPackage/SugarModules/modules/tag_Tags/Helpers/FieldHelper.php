<?php

require_once('modules/DynamicFields/DynamicField.php');

class FieldHelper extends DynamicField
{
    /**
     * Adds a field to the custom/modules/{module}/metadata/SearchFields.php array
     * This will update an existing definition
     *
     * @param string $module - key of the module to add the def to
     * @param string $name - id of the field for the def. This will be the def key.
     * @param array $definition - the definition to add.
     */
    function addSearchField($module, $name, $definition)
    {
        require_once('modules/ModuleBuilder/parsers/parser.searchfields.php');
        $parserObj = new ParserSearchFields($module);
        $searchFields =  $parserObj->getSearchFields();

        //add search field
        $searchFields[$module][$name] = $definition;

        //save new metadata
        $parserObj->saveSearchFields($searchFields);
    }

    /**
     * checks custom/modules/{module}/metadata/SearchFields.php for an entry
     *
     * @param string $module - key of the module to add the def to
     * @param string $name - id of the field for the def. This will be the def key.
     */
    function checkForSearchField($module, $name)
    {
        require_once('modules/ModuleBuilder/parsers/parser.searchfields.php');
        $parserObj = new ParserSearchFields($module);
        $searchFields =  $parserObj->getSearchFields();

        if (isset($searchFields[$name]))
        {
            return true;
        }

        return false;
    }

    /**
     * Tries to figure out if a field is on the basic_search or advanced_search form
     *
     * @param string $field - id of the field for the def to check for.
     * @param string $module - key of the module to search
     * @return string $searchForm - 'basic_search' or 'advanced_search'
     */
    function locateSearchDefs($field, $moduleName)
    {
        //make field lowercase for index match
        $field = strtolower($field);

        $basic = 'basic_search';
        $advanced = 'advanced_search';
        require_once('modules/ModuleBuilder/parsers/views/SearchViewMetaDataParser.php');

        //check basic
        $parserObj = new SearchViewMetaDataParser($basic, $moduleName);
        if (isset($parserObj->_viewdefs[$field]))
        {
            return $basic;
        }


        //check advanced
        $parserObj = new SearchViewMetaDataParser($advanced, $moduleName);
        if (isset($parserObj->_viewdefs[$field]))
        {
            return $advanced;
        }

        return false;
    }

    /**
     * Install custom fields
     * @param $fields
     */
    function installCustomFields($fields)
    {
        require_once('ModuleInstall/ModuleInstaller.php');

        $moduleInstaller = new ModuleInstaller();
        $moduleInstaller->install_custom_fields($fields);
    }

    /**
     * Writes a vardef extension
     * @param $field_name
     * @param $to_save
     */
    function writeVardefExtension($field_name, $to_save)
    {
        require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
        global $beanList;
        $module_singular = $beanList[$this->module];
        $field = new TemplateField();
        $field->name = $field_name;
        parent::writeVardefExtension($module_singular, $field, $to_save);
    }
}
