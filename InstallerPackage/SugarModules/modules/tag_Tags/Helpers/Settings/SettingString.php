<?php

require_once('Setting.php');

class SettingString extends Setting
{
    protected function retrieveFormat($value)
    {
        if (is_integer($value))
        {
            $value = strval($this->value);
        }
        else if (!is_string($value))
        {
            $value = strval($this->default_value);
        }

        return $value;
    }

    protected function saveFormat($value)
    {
        if (is_integer($value))
        {
            $value = strval($this->value);
        }
        else if (!is_string($value))
        {
            $value = strval($this->default_value);
        }

        return $value;
    }
}

?>