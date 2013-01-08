<?php

require_once('Setting.php');

class SettingDate extends Setting
{
    protected function retrieveFormat($value)
    {
        return $value;
    }

    protected function saveFormat($value)
    {
        return $value;
    }
}

?>