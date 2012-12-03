<?php

require_once('Setting.php');

class SettingBoolean extends Setting
{
    protected function retrieveFormat($value)
    {
        if (!is_bool($value))
        {
            if ($value == '1' || $value == 'true')
            {
                $value = true;
            }
            else
            {
                $value = false;
            }
        }

        return $value;
    }

    protected function saveFormat($value)
    {
        if (!is_bool($value))
        {
            if ($value == '1' || $value == 'true')
            {
                $value = true;
            }
            else
            {
                $value = false;
            }
        }

        return $value;
    }
}

?>