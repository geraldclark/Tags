<?php

require_once('modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php');

class RelationshipHelper extends DeployedRelationships
{
    function runRepairs()
    {
        $MBModStrings = $GLOBALS [ 'mod_strings' ] ;
        $adminModStrings = return_module_language ( '', 'Administration' ) ; // required by ModuleInstaller

        // Run through the module installer to rebuild the relationships once after everything is done.
        require_once 'ModuleInstall/ModuleInstaller.php' ;
        $mi = new ModuleInstaller ( ) ;
        $mi->silent = true;
        $mi->rebuild_relationships();

        // now clear all caches so that our changes are visible
        require_once ('modules/Administration/QuickRepairAndRebuild.php') ;
        $rac = new RepairAndClear ( ) ;
        $rac->repairAndClearAll ( array ( 'clearAll' ), array ( $GLOBALS [ 'mod_strings' ] [ 'LBL_ALL_MODULES' ] ), true, false ) ;

        $GLOBALS [ 'mod_strings' ] = $MBModStrings ; // finally, restore the ModuleBuilder mod_strings

        //build relationship cache
        require_once('data/Relationships/RelationshipFactory.php');
        $rel = SugarRelationshipFactory::getInstance()->rebuildCache();
    }

    function installRelationship($relationshipName, $installDefs, $savedPath, $runRepair = true)
    {
        //install
        $MBModStrings = $GLOBALS [ 'mod_strings' ] ;
        $adminModStrings = return_module_language ( '', 'Administration' ) ; // required by ModuleInstaller

        $GLOBALS [ 'mod_strings' ] = $adminModStrings;
        require_once 'ModuleInstall/ModuleInstaller.php' ;
        $mi = new ModuleInstaller ( ) ;

        $mi->id_name = 'custom' . $relationshipName ; // provide the moduleinstaller with a unique name for this relationship - normally this value is set to the package key...
        $mi->installdefs = $installDefs;
        $mi->base_dir = $savedPath;
        $mi->silent = true ;

        VardefManager::clearVardef () ;

        $mi->install_relationships () ;
        $mi->install_languages () ;
        $mi->install_vardefs () ;
        $mi->install_layoutdefs () ;
        $mi->install_layoutfields() ;
        $mi->install_extensions();

        $GLOBALS [ 'mod_strings' ] = $MBModStrings ; // finally, restore the ModuleBuilder mod_strings

        if ($runRepair)
        {
            $this->runRepairs();
        }
    }

    function setupRelationshipDefinition($RHSModule, $type)
    {
        $definition = array (
            'relationship_name' => '',
            'relationship_type'=> $type,
            'lhs_module'=> $this->moduleName,
            'remove_tables' => 'true',
            'rhs_module'=> $RHSModule,
            'from_studio' => true,
        );

        return $definition;
    }

    function setupRelationshipName($definition)
    {
        $RF = new RelationshipFactory();
        $relationship = $RF->newRelationship($definition);

        return $this->getUniqueName($relationship);
    }

    function setupLayoutDefs($subpanels, $relationshipName, $savePath)
    {
        $basepath = "{$savePath}/{$relationshipName}/relationships";
        $prefix = "{$savePath}/{$relationshipName}";

        return $this->saveSubpanelDefinitions($basepath , $prefix, $relationshipName , $subpanels);
    }

    function setupVardefManyToMany($RHSModule, $relationshipName, $existingVardefs = array())
    {
        $left = array(
            'name' => $relationshipName,
            'type' => 'link',
            'relationship' => $relationshipName,
            'source' => 'non-db',
            'vname' => 'LBL_'.strtoupper($relationshipName).'_FROM_'.strtoupper($this->moduleName).'_TITLE',
        );

        $right = array (
            'name' => $relationshipName,
            'type' => 'link',
            'relationship' => $relationshipName,
            'source' => 'non-db',
            'vname' => 'LBL_'.strtoupper($relationshipName).'_FROM_'.strtoupper($RHSModule).'_TITLE',
        );

        if (isset($existingVardefs[$this->moduleName]))
        {
            $existingVardefs[$this->moduleName][] = $left;
        }
        else
        {
            $existingVardefs[$this->moduleName] = array($left);
        }

        if (isset($existingVardefs[$RHSModule]))
        {
            $existingVardefs[$RHSModule][] = $right;
        }
        else
        {
            $existingVardefs[$RHSModule] = array($right);
        }

        return $existingVardefs;
    }

    function setupLabel($system_label, $display_label, $module)
    {
        $label = array(
            'system_label' => $system_label,
            'display_label' => $display_label,
            'module' => $module,
        );

        return $label;
    }

    function setupLabelsForManyToMany($RHSModule, $relationshipName, $existingLabels = array())
    {
        global $app_list_strings;

        $keyLeft = 'LBL_'.strtoupper($relationshipName).'_FROM_'.strtoupper($this->moduleName).'_TITLE';
        $keyRight = 'LBL_'.strtoupper($relationshipName).'_FROM_'.strtoupper($RHSModule).'_TITLE';
        $valueLeft = $app_list_strings['moduleList'][$RHSModule];
        $valueRight = $app_list_strings['moduleList'][$this->moduleName];

        $existingLabels[] = $this->setupLabel($keyLeft, $valueLeft, $this->moduleName);
        $existingLabels[] = $this->setupLabel($keyRight, $valueRight, $RHSModule);

        return $existingLabels;
    }

    function createRelationshipMetaData($definition, $relationshipName, $savePath)
    {
        //create relationship
        $RF = new RelationshipFactory();
        $relationship = $RF->newRelationship($definition);

        //set relationship name
        $relationship->setName($relationshipName);

        //build installDefs
        $metadata = $relationship->buildRelationshipMetaData();
        $basepath = "{$savePath}/{$relationshipName}/relationships";
        $prefix = "{$savePath}/{$relationshipName}";
        return $this->saveRelationshipMetaData ($basepath, $prefix, $relationshipName, array($metadata[$this->moduleName]));
    }

    function createLabels($labelDefinitions, $relationshipName, $savePath)
    {
        $basepath = "{$savePath}/{$relationshipName}/relationships";
        $prefix = "{$savePath}/{$relationshipName}";
        return $this->saveLabels ($basepath , $prefix , $relationshipName , $labelDefinitions);
    }

    function createVardefs($vardefs, $relationshipName, $savePath)
    {
        $basepath = "{$savePath}/{$relationshipName}/relationships";
        $prefix = "{$savePath}/{$relationshipName}";
        $vardefsForInstaller = $this->saveVardefs ($basepath , $prefix , $relationshipName , $vardefs);

        return $vardefsForInstaller;
    }

}

