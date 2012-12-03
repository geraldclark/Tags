<?php

require_once('Setting.php');

class SettingArray extends Setting
{
    protected function retrieveFormat($value)
    {
        if (is_string($value) && $this->database)
        {
            $value = unserialize(base64_decode($value));
        }

        if (!is_array($value))
        {
            $value = array();
        }

        return $value;
    }

    protected function saveFormat($value)
    {
        if (!is_array($value))
        {
            $value = array();
        }

        if ($this->database)
        {
            $value = base64_encode(serialize($value));
        }

        return $value;
    }
}

?>