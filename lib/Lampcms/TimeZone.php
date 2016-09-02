<?php
/**
 *
 * License, TERMS and CONDITIONS
 *
 * This software is licensed under the GNU LESSER GENERAL PUBLIC LICENSE (LGPL) version 3
 * Please read the license here : http://www.gnu.org/licenses/lgpl-3.0.txt
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * ATTRIBUTION REQUIRED
 * 4. All web pages generated by the use of this software, or at least
 *       the page that lists the recent questions (usually home page) must include
 *    a link to the http://www.lampcms.com and text of the link must indicate that
 *    the website's Questions/Answers functionality is powered by lampcms.com
 *    An example of acceptable link would be "Powered by <a href="http://www.lampcms.com">LampCMS</a>"
 *    The location of the link is not important, it can be in the footer of the page
 *    but it must not be hidden by style attributes
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This product includes GeoLite data created by MaxMind,
 *  available from http://www.maxmind.com/
 *
 *
 * @author     Dmitri Snytkine <cms@lampcms.com>
 * @copyright  2005-2012 (or current year) Dmitri Snytkine
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU LESSER GENERAL PUBLIC LICENSE (LGPL) version 3
 * @link       http://www.lampcms.com   Lampcms.com project
 * @version    Release: 0.2.45
 *
 *
 */


namespace Lampcms;


/**
 * Class for creating
 * array of time zones
 */
class TimeZone extends \DateTimeZone
{

    const MENU = <<<EOD
<option value="UTC">(GMT-12:00) International Date Line West</option>
<option value="Pacific/Pago_Pago">(GMT-11:00) Midway Island, Samoa</option>
<option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
<option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>
<option value="America/Phoenix">(GMT-07:00) Arizona</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
<option value="America/Guatemala">(GMT-06:00) Central America</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US &amp; Canada)</option>
<option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="America/Regina">(GMT-06:00) Saskatchewan</option>
<option value="America/Lima">(GMT-05:00) Bogota, Lima, Quito</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
<option value="America/Indianapolis">(GMT-05:00) Indiana (East)</option>
<option value="America/Halifax">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/La_Paz">(GMT-04:00) Caracas, La Paz</option>
<option value="America/Manaus">(GMT-04:00) Manaus</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="Atlantic/South_Georgia">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Africa/Casablanca">(GMT) Casablanca, Monrovia</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Europe/Warsaw">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
<option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>
<option value="Asia/Amman">(GMT+02:00) Amman</option>
<option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
<option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
<option value="Asia/Baghdad">(GMT+03:00) Baghdad</option>
<option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
<option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Baku">(GMT+04:00) Baku</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
<option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Colombo">(GMT+05:30) Sri Jayawardenepura</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyars</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Asia/Singapore">(GMT+08:00) Kuala Lumpur, Singapore</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Asia/Taipei">(GMT+08:00) Taipei</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Sydney">(GMT+10:00) Canberra, Melbourne, Sydney</option>
<option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Pacific/Noumea">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku&#39;alofa</option></select>
EOD;

    /**
     * This is borrowed from the Jon Nylander's timeZoneDetect javascript
     * https://bitbucket.org/pellepim/jstimezonedetect
     *
     * The keys in this dictionary are comma separated as such:
     *
     * First the offset compared to UTC time in minutes.
     *
     * Then a flag which is 0 if the timezone does not take daylight savings into account and 1 if it
     * does.
     *
     * Thirdly an optional 's' signifies that the timezone is in the southern hemisphere,
     * only interesting for timezones with DST.
     *
     * The mapped arrays is used for constructing the jstz.TimeZone object from within
     * jstz.determine_timezone();
     *
     * @var array
     */
    public static
        $commonZones = array(
        '-720,0'   => 'Etc/GMT+12',
        '-660,0'   => 'Pacific/Pago_Pago',
        '-600,1'   => 'America/Adak',
        '-600,0'   => 'Pacific/Honolulu',
        '-570,0'   => 'Pacific/Marquesas',
        '-540,0'   => 'Pacific/Gambier',
        '-540,1'   => 'America/Anchorage',
        '-480,1'   => 'America/Los_Angeles',
        '-480,0'   => 'Pacific/Pitcairn',
        '-420,0'   => 'America/Phoenix',
        '-420,1'   => 'America/Denver',
        '-360,0'   => 'America/Guatemala',
        '-360,1'   => 'America/Chicago',
        '-360,1,s' => 'Pacific/Easter',
        '-300,0'   => 'America/Bogota',
        '-300,1'   => 'America/New_York',
        '-270,0'   => 'America/Caracas',
        '-240,1'   => 'America/Halifax',
        '-240,0'   => 'America/Santo_Domingo',
        '-240,1,s' => 'America/Asuncion',
        '-210,1'   => 'America/St_Johns',
        '-180,1'   => 'America/Godthab',
        '-180,0'   => 'America/Argentina/Buenos_Aires',
        '-180,1,s' => 'America/Montevideo',
        '-120,0'   => 'America/Noronha',
        '-120,1'   => 'Etc/GMT+2',
        '-60,1'    => 'Atlantic/Azores',
        '-60,0'    => 'Atlantic/Cape_Verde',
        '0,0'      => 'Etc/UTC',
        '0,1'      => 'Europe/London',
        '60,1'     => 'Europe/Berlin',
        '60,0'     => 'Africa/Lagos',
        '60,1,s'   => 'Africa/Windhoek',
        '120,1'    => 'Asia/Beirut',
        '120,0'    => 'Africa/Johannesburg',
        '180,1'    => 'Europe/Moscow',
        '180,0'    => 'Asia/Baghdad',
        '210,1'    => 'Asia/Tehran',
        '240,0'    => 'Asia/Dubai',
        '240,1'    => 'Asia/Yerevan',
        '270,0'    => 'Asia/Kabul',
        '300,1'    => 'Asia/Yekaterinburg',
        '300,0'    => 'Asia/Karachi',
        '330,0'    => 'Asia/Kolkata',
        '345,0'    => 'Asia/Kathmandu',
        '360,0'    => 'Asia/Dhaka',
        '360,1'    => 'Asia/Omsk',
        '390,0'    => 'Asia/Rangoon',
        '420,1'    => 'Asia/Krasnoyarsk',
        '420,0'    => 'Asia/Jakarta',
        '480,0'    => 'Asia/Shanghai',
        '480,1'    => 'Asia/Irkutsk',
        '525,0'    => 'Australia/Eucla',
        '525,1,s'  => 'Australia/Eucla',
        '540,1'    => 'Asia/Yakutsk',
        '540,0'    => 'Asia/Tokyo',
        '570,0'    => 'Australia/Darwin',
        '570,1,s'  => 'Australia/Adelaide',
        '600,0'    => 'Australia/Brisbane',
        '600,1'    => 'Asia/Vladivostok',
        '600,1,s'  => 'Australia/Sydney',
        '630,1,s'  => 'Australia/Lord_Howe',
        '660,1'    => 'Asia/Kamchatka',
        '660,0'    => 'Pacific/Noumea',
        '690,0'    => 'Pacific/Norfolk',
        '720,1,s'  => 'Pacific/Auckland',
        '720,0'    => 'Pacific/Tarawa',
        '765,1,s'  => 'Pacific/Chatham',
        '780,0'    => 'Pacific/Tongatapu',
        '780,1,s'  => 'Pacific/Apia',
        '840,0'    => 'Pacific/Kiritimati'
    );

    /**
     * Generates array suitable
     * for using it in QuickForm
     * to create drop-down menu of
     * time zones.
     *
     * @return array where keys
     * are time zone names and values
     * are strings indicating GMT offset
     * followed by timezone name.
     * This array is sorted by keys
     * (by timezone names)
     *
     * @deprecated
     */
    public static function getSelectArray()
    {
        $arrResult = array();
        $arr       = self::listAbbreviations();

        foreach ($arr as $abbr) {
            foreach ($abbr as $aTz) {

                $sign = ($aTz['offset'] < 0) ? '-' : (($aTz['offset'] > 0) ? '+' : '');
                $gmt  = abs($aTz['offset']) / 3600;
                $hh   = $gmt; //floor($gmt);
                $mm   = $gmt - $hh;
                $mm   = ($mm * 60); //floor($mm * 60);
                $key  = $aTz['timezone_id'];
                $val  = '(GMT' . $sign . sprintf("%02s", $hh) . ':' . sprintf("%02s", $mm) . ') ' . $aTz['timezone_id'];
                if (!empty($key) && !empty($val)) {
                    $arrResult[$key] = $aTz['offset'] . ' ' . $val;
                }
            }
        }

        ksort($arrResult);

        return $arrResult;
    }


    /**
     *
     * Get HTML for the select menu options (without the <select></select> tags)
     * to select
     * a timezone
     *
     * @param string $current current timezone to be set as "selected" in the menu
     *
     * @return string html code for the <option> element
     */
    public static function getMenu($current = null)
    {

        $a   = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL ^ \DateTimeZone::UTC);
        $res = '';
        foreach ($a as $zone) {

            $selected = ($zone === $current) ? " selected" : '';
            $val      = str_replace('_', ' ', $zone);
            $res .= "\n<option value=\"$zone\"$selected>$val</option>";
        }

        return $res;
    }

    /**
     * Get html of the timezone options. If intl extension is installed
     * and locale passed in not english language locale then attempt to
     * translate each timezone name into the language of locale
     *
     * @param string $locale    The timezone names will be translated
     *                          to language of the locale
     *
     * @param bool   $translate if this flag is false then do not translate
     *                          having this flag allow to skip translation and return original html
     *
     *
     * @return string html string with timezone options
     */
    public static function getMenuOptions($locale = 'en_US', $translate = true)
    {
        if (!$translate || (0 === \strncasecmp('en', $locale, 2)) || !\extension_loaded('intl')) {
            d('using default menu');
            return self::MENU;
        }

        return self::translateOptions($locale);
    }


    /**
     * Use intl extension for translation
     * return the self::MENU string with each name of timezone translated
     * into language of locale. Value of timezone will remain the same
     *
     * @param $locale
     *
     * @return mixed
     */
    protected static function translateOptions($locale)
    {
        d('locale: ' . $locale);
        $ts        = time();
        $Formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, "UTC", NULL, 'vvvv');
        $ret       = \preg_replace_callback('/value="([a-zA-Z_\/]+)">([^<]*)</', function($matches) use ($Formatter, $ts)
        {
            $Formatter->setTimeZoneId($matches[1]);
            $res = $Formatter->format($ts);
            return 'value="' . $matches[1] . '">' . $res . '<';
        }, self::MENU);

        return $ret;
    }


    /**
     * Extracts value of timezone_offset from a timezone string.
     *
     * @param string $strTimezone  timezone string
     * @param array  $arrTimezones array of timezones
     *
     * @return integer number of seconds, can be a negative number
     */
    public static function getTimezoneOffset($strTimezone, $arrTimezones)
    {
        $res = '0';
        preg_match('/\(GMT(([\-+]{1})([0-9]{2}):([0-9]{2}))\)/', $arrTimezones[$strTimezone], $matches);

        if (isset($matches[2]) && isset($matches[3]) && isset($matches[4])) {
            $intSeconds = ($matches[3] * 60 * 60) + ($matches[4] * 60);
            $prefix     = ($matches[2] == '-') ? '-' : '';
            $res        = trim($prefix . $intSeconds);
        }

        return (int)$res;
    }


    /**
     * Get the first available timezone name
     * that matches the offset value (in seconds)
     *
     * @param int     $intOffset
     * @param bool    $asCommonZone
     *
     * @internal param number $offset of seconds from GMT
     *
     * @return first matching timezone name, always trying to get
     *           the most common name of timezone
     */
    public static function getTZbyoffset($intOffset, $asCommonZone = true)
    {
        $tza = \DateTimeZone::listAbbreviations();

        foreach ($tza as $abbr) {
            foreach ($abbr as $zone) {
                if ($zone['offset'] === (int)$intOffset) {
                    if (!$asCommonZone) {
                        return $zone['timezone_id'];
                    }

                    if (!isset($firstGuess)) {
                        $firstGuess = $zone['timezone_id'];
                    }

                    if (in_array($zone['timezone_id'], self::$commonZones)) {
                        return $zone['timezone_id'];
                    }

                }
            }
        }

        /**
         * If $asCommonZone was true and no result was found
         * in $commonZones map then return the first match
         * else return empty string
         */
        return (isset($firstGuess)) ? $firstGuess : '';
    }


    /**
     * @static
     *
     * @return string php timezone name
     */
    public static function guessTimeZone()
    {

    }

}