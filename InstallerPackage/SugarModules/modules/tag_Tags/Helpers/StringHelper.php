<?php

class StringHelper
{
    /**
     * Formats a phone number
     * @param $phoneNumber
     * @return mixed
     */
    function formatPhoneNumber($phoneNumber)
    {
        //only spaces, x and numbers allowed
        $phoneNumber = preg_replace('/[^xX0-9]/', ' ', $phoneNumber);
        //remove spaces
        $phoneNumber = preg_replace('/ /', '', $phoneNumber);
        return $phoneNumber;
    }

    /** Formats an OS safe filename
     * @param $filename
     * @return mixed
     */
    function formatFilename($filename)
    {
        $replace = " ";
        $pattern = "/([[:alnum:]_\.-]*)/";
        $filename = str_replace(str_split(preg_replace($pattern, $replace, $filename)), $replace, $filename);
        return $filename;
    }

    /**
     * Formats an address
     * @param $street
     * @param $city
     * @param $state
     * @param $zip
     * @param $country
     * @return string
     */
    function formatAddress($street, $city, $state, $zip, $country)
    {
        $address = array($street, $city, trim($state . " " .  $zip), $country);
        //remove emptys
        foreach($address as $key => $value)
        {
            if ( empty($value) )
            {
                unset($address[$key]);
            }
        }
        $addressString = implode(', ', $address);
        return $addressString;
    }

    /**
     * Searches for a string
     * @param $needles
     * @param $haystack
     * @return bool
     */
    function hasString($needles, $haystack)
    {
        if (!is_array($needles))
        {
            $needles = array($needles);
        }

        $found = false;
        foreach ($needles as $needle)
        {
            $needle = strtoupper($needle);
            $haystack = strtoupper($haystack);
            $position = strpos($haystack, $needle);

            if($position === false)
            {
                //do nothing
            }
            else
            {
                $found = true;
                break;
            }
        }

        return $found;
    }

    /**
     * Replaces the last ocurance of a string
     * @param $search
     * @param $replace
     * @param $subject
     * @return mixed
     */
    function str_last_replace($search, $replace, $subject)
    {
        $string = preg_replace('~(.*)' . preg_quote($search, '~') . '~', '$1' . $replace, $subject, 1);
        return $string;
    }

    function isGUID($guid)
    {
        $return = false;
        if (preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $guid))
        {
            $return = true;
        }

        return $return;
    }
}

?>

