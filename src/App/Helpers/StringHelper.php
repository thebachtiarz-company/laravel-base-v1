<?php

namespace TheBachtiarz\Base\App\Helpers;

class StringHelper
{
    //

    /**
     * Create shuffle string.
     * 
     * Default: Upper Case Only
     *
     * @param integer $count
     * @param boolean $withLowerCase Set true for include lower case characters
     * @return string
     */
    public static function shuffleString(int $count, bool $withLowerCase = false): string
    {
        $theStr = "QWEASDZXCRTYFGHVBNUIOJKLMP";

        if ($withLowerCase)
            $theStr .= "qweasdzxcrtyfghvbnuiojklmp";

        $getStr = str_shuffle($theStr);

        return substr($getStr, 0, $count);
    }

    /**
     * Create shuffle number.
     * 
     * Length: 1 - 10 Digit(s).
     *
     * @param integer $count
     * @return string
     */
    public static function shuffleNumber(int $count): string
    {
        $theNum = (string) mt_rand(1000000000, 9999999999);

        $getNUm = str_shuffle($theNum);

        return substr($getNUm, 0, $count);
    }
}
