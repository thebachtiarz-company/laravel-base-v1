<?php

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Support\Carbon;
use TheBachtiarz\Base\App\Interfaces\CarbonInterface;

class CarbonHelper extends Carbon
{
    //

    /**
     * Split human date time type available
     *
     * @var array
     */
    public static array $splitHumanDateTimeType = [
        'date' => CarbonInterface::CARBON_HUMAN_DATE_FORMAT,
        'time' => CarbonInterface::CARBON_HUMAN_TIME_FORMAT
    ];

    /**
     * Split system date time type available
     *
     * @var array
     */
    public static array $splitSystemDateTimeType = [
        'date' => CarbonInterface::CARBON_DB_DATE_FORMAT,
        'time' => CarbonInterface::CARBON_DB_TIME_FORMAT
    ];

    /**
     * Init new self carbon.
     *
     * For customize the carbon it self.
     *
     * @return Carbon
     */
    public static function init(): Carbon
    {
        return new Carbon;
    }

    // ? Date Format
    /**
     * Get full date time now.
     *
     * For human.
     *
     * @param Carbon|string|null $dateStart
     * @return string
     */
    public static function humanFullDateTimeNow(Carbon|string|null $dateStart = null): string
    {
        return Carbon::parse($dateStart ?? Carbon::now())
            ->setTimezone(tbbaseconfig('app_timezone'))
            ->isoFormat(CarbonInterface::CARBON_FULL_HUMAN_DATE_FORMAT);
    }

    /**
     * Get date time now in timezone
     *
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbDateTimeNowTimezone(Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->setTimezone(tbbaseconfig('app_timezone'));
    }

    /**
     * Parse date time.
     *
     * For human.
     *
     * @param Carbon|string|null $datetime
     * @param string $split Value: date|time
     * @return string
     */
    public static function humanDateTime(Carbon|string|null $datetime = null, string $split = ''): string
    {
        $format = CarbonInterface::CARBON_HUMAN_SIMPLE_DATE_FORMAT;

        if (in_array($split, array_keys(static::$splitHumanDateTimeType))) {
            $format = static::$splitHumanDateTimeType[$split];
        }

        return Carbon::parse($datetime ?? Carbon::now())->format($format);
    }

    /**
     * Parse date time.
     *
     * For database.
     *
     * @param Carbon|string|null $datetime
     * @param string $split
     * @return string
     */
    public static function dbDateTime(Carbon|string|null $datetime = null, string $split = ''): string
    {
        $format = CarbonInterface::CARBON_DB_SIMPLE_DATE_FORMAT;

        if (in_array($split, array_keys(static::$splitSystemDateTimeType))) {
            $format = static::$splitSystemDateTimeType[$split];
        }

        return Carbon::parse($datetime ?? Carbon::now())->format($format);
    }

    /**
     * Get interval date created from date updated
     *
     * @param Carbon|string $dateCreated
     * @param Carbon|string $dateUpdated
     * @return string
     */
    public static function humanIntervalCreateUpdate(Carbon|string $dateCreated, Carbon|string $dateUpdated): string
    {
        return self::anyConvDateToTimestamp($dateUpdated) > self::anyConvDateToTimestamp($dateCreated) ? self::humanIntervalDateTime($dateUpdated) : '-';
    }

    /**
     * Convert date time to timestamp
     *
     * @param Carbon|string|null $datetime
     * @param boolean $withMilli
     * @return string
     */
    public static function anyConvDateToTimestamp(Carbon|string|null $datetime = null, bool $withMilli = false): string
    {
        $_format = "U";

        if ($withMilli) $_format .= "u";

        return Carbon::parse($datetime ?? Carbon::now())->format($_format);
    }

    /**
     * Convert timestamp to date time
     *
     * @param string $timestamp default: now()
     * @return string
     */
    public static function dbTimestampToDateTime(string $timestamp = ''): string
    {
        return iconv_strlen($timestamp)
            ? Carbon::createFromFormat('U', $timestamp)->format(CarbonInterface::CARBON_DB_SIMPLE_DATE_FORMAT)
            : self::dbDateTime();
    }

    /**
     * Convert date time to interval time from now.
     *
     * For Human.
     *
     * @param Carbon|string $datetime
     * @return string
     */
    public static function humanIntervalDateTime(Carbon|string $datetime): string
    {
        return Carbon::parse($datetime)->diffForHumans();
    }

    /**
     * Get date time by specific add years from now.
     *
     * For database.
     *
     * @param integer $years
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddYears(int $years = 1, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addYears($years);
    }

    /**
     * Get date time by specific add months from now.
     *
     * For database.
     *
     * @param integer $months
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddMonths(int $months = 6, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addMonths($months);
    }

    /**
     * Get date time by specific add weeks from now.
     *
     * For database.
     *
     * @param integer $weeks
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddWeeks(int $weeks = 1, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addWeeks($weeks);
    }

    /**
     * Get date time by specific add days from now.

     * For database.
     *
     * @param integer $days
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddDays(int $days = 30, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addDays($days);
    }

    /**
     * Get date time by specific add hours from now.
     *
     * For database.
     *
     * @param integer $hours
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddHours(int $hours = 24, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addHours($hours);
    }

    /**
     * Get date time by specific add minutes from now.
     *
     * For database.
     *
     * @param integer $minutes
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddMinutes(int $minutes = 60, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addMinutes($minutes);
    }

    /**
     * Get date time by specific add seconds from now.
     *
     * For database.
     *
     * @param integer $seconds
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateAddSeconds(int $seconds = 60, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->addSeconds($seconds);
    }

    /**
     * Get date time by specific sub years from now.
     *
     * For database.
     *
     * @param integer $years
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubYears(int $years = 1, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subYears($years);
    }

    /**
     * Get date time by specific sub months from now.
     *
     * For database.
     *
     * @param integer $months
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubMonths(int $months = 6, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subMonths($months);
    }

    /**
     * Get date time by specific sub weeks from now.
     *
     * For database.
     *
     * @param integer $weeks
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubWeeks(int $weeks = 1, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subWeeks($weeks);
    }

    /**
     * Get date time by specific sub days from now.
     *
     * For database.
     *
     * @param integer $days
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubDays(int $days = 30, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subDays($days);
    }

    /**
     * Get date time by specific sub hours from now.
     *
     * For database.
     *
     * @param integer $hours
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubHours(int $hours = 24, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subHours($hours);
    }

    /**
     * Get date time by specific sub minutes from now.
     *
     * For database.
     *
     * @param integer $minutes
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubMinutes(int $minutes = 60, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subMinutes($minutes);
    }

    /**
     * Get date time by specific sub seconds from now.
     *
     * For database.
     *
     * @param integer $seconds
     * @param Carbon|string|null $dateStart
     * @return Carbon
     */
    public static function dbGetFullDateSubSeconds(int $seconds = 60, Carbon|string|null $dateStart = null): Carbon
    {
        return Carbon::parse($dateStart ?? Carbon::now())->subSeconds($seconds);
    }

    /**
     * Check is date given is equal with format given
     *
     * @param string $date
     * @param string $format
     * @return boolean
     */
    public static function isFormatEqual(string $date, string $format): bool
    {
        return Carbon::hasFormat($date, $format);
    }

    // ? End of Date Format

    // ? Person
    /**
     * Convert date time to person age
     *
     * @param Carbon|string $datetime
     * @return integer
     */
    public static function humanGetPersonAge(Carbon|string $datetime): int
    {
        return Carbon::parse($datetime)->age;
    }

    /**
     * Convert date time to person born date full
     *
     * @param Carbon|string $datetime
     * @return array
     */
    public static function humanGetPersonBornDateFull(Carbon|string $datetime): array
    {
        $born = Carbon::parse($datetime);

        $date = $born->format(CarbonInterface::CARBON_HUMAN_DATE_FORMAT);

        $age = (string) $born->age;

        return compact(['date', 'age']);
    }

    /**
     * Check is person birthday today
     *
     * @param Carbon|string $datetime
     * @return boolean
     */
    public static function isPersonBirthdayToday(Carbon|string $datetime): bool
    {
        $born = Carbon::parse($datetime);

        return $born->isBirthday();
    }
    // ? End of Person
}
