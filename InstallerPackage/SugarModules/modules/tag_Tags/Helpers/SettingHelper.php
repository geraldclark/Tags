<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'Settings/SettingArray.php';
require_once 'Settings/SettingBoolean.php';
require_once 'Settings/SettingInteger.php';
require_once 'Settings/SettingString.php';
require_once 'Settings/SettingDate.php';

class SettingHelper
{
	public function __construct() {}

	public function save()
	{
		$properties = get_object_vars($this);

		$results = array();
		foreach ($properties as $property)
		{
			$results[$property->getName()] = $this->{$property->getName()}->save();
		}

		return $results;
	}

	public function saveFromRequest($checkEmptySettings = array())
	{
		$properties = get_object_vars($this);

		$results = array();
		foreach ($properties as $property)
		{
			if (isset($_REQUEST[$property->getId()]))
			{
				$this->{$property->getName()}->value = $_REQUEST[$property->getId()];
				$results[$property->getName()] = $this->{$property->getName()}->save();
			}
            else if (in_array($property->getName(), $checkEmptySettings))
            {
                if (!isset($_REQUEST[$property->getId()]))
                {
                    $this->{$property->getName()}->setDefaultValue();
                    $results[$property->getName()] = $this->{$property->getName()}->save();
                }
            }
		}

		return $results;
	}
}
