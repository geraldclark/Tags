<?php

require_once('Settings/SettingArray.php');
require_once('Settings/SettingBoolean.php');
require_once('Settings/SettingInteger.php');
require_once('Settings/SettingString.php');

class SettingHelper
{
    public function __construct()
    {

    }

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

}