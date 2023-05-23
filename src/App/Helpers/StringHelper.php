<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use function mb_strlen;
use function mt_rand;
use function random_int;
use function str_shuffle;

class StringHelper
{
    /**
     * Create shuffle from string and number
     */
    public static function shuffleBoth(int $length): string
    {
        $chars = self::shuffleString(100, true) . self::shuffleNumber(100);

        $shuffleChars = str_shuffle($chars);
        $charsLength  = mb_strlen($shuffleChars);

        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $shuffleChars[random_int(0, $charsLength - 1)];
        }

        return $result;
    }

    /**
     * Create shuffle string.
     *
     * Default: Upper Case Only
     *
     * @param bool $withLowerCase Set true for include lower case characters
     */
    public static function shuffleString(int $length, bool $withLowerCase = false): string
    {
        $chars = 'QWEASDZXCRTYFGHVBNUIOJKLMP';

        if ($withLowerCase) {
            $chars .= 'qweasdzxcrtyfghvbnuiojklmp';
        }

        $shuffleChars = str_shuffle($chars);
        $charsLength  = mb_strlen($shuffleChars);

        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $shuffleChars[random_int(0, $charsLength - 1)];
        }

        return $result;
    }

    /**
     * Create shuffle number.
     *
     * Length: 1 - 10 Digit(s).
     */
    public static function shuffleNumber(int $length): string
    {
        $chars = (string) mt_rand(1000000000, 9999999999);

        $shuffleChars = str_shuffle($chars);
        $charsLength  = mb_strlen($shuffleChars);

        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $shuffleChars[random_int(0, $charsLength - 1)];
        }

        return $result;
    }
}
