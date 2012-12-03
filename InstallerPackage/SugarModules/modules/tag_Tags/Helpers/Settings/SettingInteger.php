<?php

require_once('Setting.php');

class SettingInteger extends Setting
{
    protected function retrieveFormat($value)
    {
        if (!is_integer($value))
        {
            $value = (int)intval($this->default_value);
        }

        return $value;
    }

    protected function saveFormat($value)
    {
        if (is_string($value))
        {
            $value = (int)intval($value);
        }
        else if (!is_integer($value))
        {
            $value = (int)intval($this->default_value);
        }

        return $value;
    }
}

?>