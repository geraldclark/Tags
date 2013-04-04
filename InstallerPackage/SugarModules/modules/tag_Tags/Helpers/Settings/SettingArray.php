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

        if (!is_array($value) && is_string($value))
        {
            $value = array($value);
        }
        elseif (!is_array($value))
        {
            $value = array();
        }

        return $value;
    }

    protected function saveFormat($value)
    {
        if (!is_array($value))
        {
            $value = array($value);
        }

        if ($this->database)
        {
            $value = base64_encode(serialize($value));
        }

        return $value;
    }

    /**
     * Checks if the value is an acceptable value
     */
    protected function checkPossibleValues()
    {
        if ($this->possible_values !== null && !empty($this->value))
        {
            if (is_array($this->possible_values) && is_array($this->value))
            {
                foreach ($this->value as $key=>$value)
                {
                    if (!in_array($value, array_keys($this->possible_values)))
                    {
                        unset($this->value[$key]);

                        $GLOBALS['log']->fatal("Settings :: The setting '{$this->name}' was had '$value' removed because it is an invalid selection.");
                    }
                }
            }
        }
    }

}