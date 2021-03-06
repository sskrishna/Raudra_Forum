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
 * Object representation of string
 *
 * @author Dmitri Snytkine
 *
 */
class String extends LampcmsObject implements \Serializable
{

    /**
     * The string that this object represents
     *
     * @var string
     */
    protected $string;

    /**
     * This mode indicates how
     * we return the result
     * when the result is a new string
     *
     * The default is 'immutable' mode
     * which means that a new object of this class
     * is created for the new string and returned
     *
     * Another option is to set it
     * to 'StringBuilder' which simulates the Java StringBuilder object
     * in which case when string changes, only the
     * instance of $this->string is changing (object is not immutable in
     * this case) and $this is returned
     *
     * The StringBuilder is more efficient because it does not
     * create a new object every time the string changes
     *
     * Default is 'immutable'
     *
     * @var string
     */
    protected $returnMode = 'default';

    /**
     * Constructor
     *
     * @param string $string
     * @param string $returnMode if set to StringBuilder will set the StringBuilder return mode
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($string, $returnMode = 'default')
    {
        if (!\is_string($string) && !\is_int($string) && !\is_object($string)) {
            $err = '$string must be a string of int. Was: ' . gettype($string);
            e($err);
            throw new \InvalidArgumentException($err);
        }

        if (\is_object($string)) {

            if (!($string instanceof \Lampcms\String)) {
                $err = '$string must be instance of \Lampcms\String class';
                e($err);
                throw new \InvalidArgumentException($err);
            }

            $string = $string->valueOf();
        }

        d('cp');

        $this->string = (string)$string;

        $this->returnMode = $returnMode;

    }

    /**
     * Setter for returnMode
     * Should be default or StringBuilder
     * but basically if it's any string other
     * that StringBuilder, it will set the return
     * mode to default, making this an immutable object
     *
     * @param $mode
     *
     * @throws \InvalidArgumentException
     * @return \Lampcms\object $this
     */
    public function setReturnMode($mode)
    {
        if (!is_string($mode)) {
            throw new \InvalidArgumentException('$mode must be a string');
        }

        $this->returnMode = $mode;

        return $this;
    }

    /**
     * Getter for returnMode
     *
     * @return string
     */
    public function getReturnMode()
    {
        return $this->returnMode;
    }

    /**
     * Factory method but cannot call it factory
     * due to some bug in certain php versions
     * that raise error if static method signature
     * is not the same as in parent class
     *
     * @param string $string
     *
     * @return \Lampcms\String
     */
    public static function stringFactory($string)
    {

        $o = new \Lampcms\String($string);

        return $o;
    }


    /**
     * @todo unfinished
     *
     */
    public function __clone()
    {

    }


    /**
     * (non-PHPdoc)
     *
     * @see Lampcms.LampcmsObject::__toString()
     */
    public function __toString()
    {
        return $this->string;
    }


    /**
     *
     * @return string value of $this->string
     */
    public function valueOf()
    {
        return $this->string;
    }


    /**
     * (non-PHPdoc)
     *
     * @see Lampcms.LampcmsObject::hashCode()
     */
    public function hashCode()
    {
        return $this->getMd5();
    }


    /**
     * Tests to see if the string
     * contains html
     *
     * @return bool true if string contains html tags, false otherwise
     */
    public function isHtml()
    {

        return (\strlen(\strip_tags($this->string)) !== \strlen($this->string));
    }


    /**
     * (non-PHPdoc)
     *
     * @see Serializable::serialize()
     */
    public function serialize()
    {
        return \serialize(array('s' => $this->string, 'm' => $this->returnMode));
    }


    /**
     * (non-PHPdoc)
     *
     * @see Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        $a                = \unserialize($serialized);
        $this->string     = $a['s'];
        $this->returnMode = $a['m'];
    }


    /**
     * Returns number of lines in a string
     * This is utf-8 safe,
     * so no need to override in utf8 string class
     *
     * @return int number of lines
     */
    public function getLinesCount()
    {

        $a = \explode("\n", trim($this->string, "\n"));

        return count($a);
    }


    /**
     * Counts number of words in a string
     *
     * @internal param string $str
     *
     * @return int number of words in a string
     */
    public function getWordsCount()
    {

        return \str_word_count($this->string, 0, '0123456789-');
    }


    /**
     * Return number of sentences in a string
     * sentence is spotted by the end-of-sentence
     * punctuation mark: ., !, or ?
     * that is NOT followed by a word.
     *
     * @internal param $str
     *
     * @return int number of sentences in a string
     */
    public function getSentencesCount()
    {

        return \preg_match_all('/(?:[\w])([\.!?])(?!\w)/m', $this->string, $match);
    }


    /**
     * Get string length in bytes
     * It is important to understand that
     * for normal ASCII string this is also the number
     * of chars in string, but for utf-8 this may be
     * different. That's why this method would be
     * overridden in Utf8String class
     *
     * @return int length of string in bytes
     *
     */
    public function length()
    {

        return \strlen($this->string);
    }


    /**
     *
     * @return md5 hash of $this->string
     */
    public function getMd5()
    {
        return \md5($this->string);
    }


    /**
     *
     * @return crc32 value of this string
     */
    public function getCrc32()
    {
        return \crc32($this->string);
    }


    /**
     * Remove (mask) some chars from email address
     * so that it becomes not valid for email harvesters
     * and can be displayed on the web page
     *
     * @param object of this type
     * @return object
     */
    public function obfuscateEmail()
    {
        $str = \preg_replace('/([a-zA-Z0-9_\.]{2,})(@)/Ume', "substr('\\1', 0, rand((floor(strlen('\\1') / 2)), (floor(strlen('\\1') / 2) + 1))).'### @'", $this->string);

        return $this->handleReturn($str);
    }


    /**
     * Strip tags but preserve white spaces
     *
     * @return object of this class representing
     * new string
     */
    public function asPlainText()
    {
        if (!$this->isHtml()) {

            return $this->handleReturn($this->string);
        }

        /**
         * Remove all the < brackets with space
         * so that when tags are stripped we will
         * not lose any spaces
         */
        $text = \str_replace('<', ' <', $this->string);
        $text = \strip_tags($text);
        $text = \preg_replace('/[\n\r\t]+/', ' ', $text);
        $text = \preg_replace('!\s+!', ' ', $text);

        return $this->handleReturn(\trim($text));
    }


    public function stripTags(array $aAllowed = null)
    {
        $ret = \strip_tags($this->string, $aAllowed);

        return $this->handleReturn($ret);
    }


    /**
     * Generates random alphanumeric string
     * of predetermined length
     *
     * @param int|\Lampcms\intered $len
     *
     * @return string a string of random letters and numbers.
     */
    public static function makeRandomString($len = 30)
    {

        $strAlphanum = 'abcdefghijklmnopqrstuvwqyz0123456789';
        $len         = (int)$len;
        $aAlphanum   = \str_split($strAlphanum);
        $strRes      = '';
        for ($i = 0; $i < $len; $i += 1) {
            $key  = \mt_rand(0, 35);
            $char = $aAlphanum[$key];
            $strRes .= (1 === \mt_rand(0, 1) && !\is_numeric($char)) ? \strtoupper($char) : $char;
        }

        return $strRes;
    }


    /**
     * Make random string that will be used
     * as value of 'sid' cookie
     * The value is generated based on current microtime
     * so the string always starts with current microtime,
     * then the letter a and remainder is a random string
     * with the length necessary to make the total length
     * equal to $len param
     *
     * @param int $len the total length of generated sid
     *
     * @return string random string of $len chars
     * the string always starts with microtime value
     * then char 'a' and then random string
     * This way we can always extract the microtime
     * from it and find out when user first got this cookie
     * meaning we don't even need to set a separate 'first visit'
     * cookie!
     *
     */
    public static function makeSid($len = 48)
    {
        $prefix = \microtime(true) . 'a';
        $rs     = self::makeRandomString($len - \strlen($prefix));

        return $prefix . $rs;
    }


    /**
     * Returns sha256 hashed password
     * using LAMPCMS_SALT from settings as salt
     *
     * @param string $pwd password to hash
     *
     * @return string md5 hash of VERSION + $pwd
     */
    public static function hashPassword($pwd)
    {
        $salt = LAMPCMS_SALT;

        return \hash('sha256', $salt . $pwd);
    }


    /**
     * Create random number on 6 to 8 digits long
     * This is useful to generate initial password
     * for a new user
     *
     * This method will also make sure that password
     * has at least one number character in it in order
     * to pass password validation which requires the password
     * to have letters and numbers
     *
     * @param int $minLen
     * @param int $maxLen
     *
     * @return string a randomly generate password
     */
    public static function makePasswd($minLen = 6, $maxLen = 8)
    {
        $len = \mt_rand($minLen, $maxLen);
        d('len: ' . $len);
        $pwd = self::makeRandomString($len);


        /**
         * if result string does not have at least one number
         * then append one digit to the end of string
         * this is so that the password will pass
         * the validator during login process,
         * which requires the password to have at least one digit
         */
        if (0 === \preg_match('/\d/', $pwd)) {
            $digit = \mt_rand(0, 9);
            $pwd .= $digit;

            /**
             * Now that we added an extra char
             * to end of string, we must remove
             * the first char to keep the string to be
             * not over the maxLen value
             *
             * But only if it exceeded $maxLen
             */
            if (strlen($pwd) > $maxLen) {
                $pwd = \substr($pwd, 1);
            }
        }

        return $pwd;
    }


    /**
     * Wraps the string inside this html (or xml) tag
     *
     * @param string $tag defaults to <pre>
     *                    MUST specify tag without the < > brackets, just a tag name
     *                    for example 'div'
     *
     * @return object of this class (new object or $this)
     */
    public function wrapInTag($tag = 'pre')
    {
        $string = '<' . $tag . '>' . $this->string . '</' . $tag . '>';

        return $this->handleReturn($string);
    }


    /**
     * Handles the return function
     * depending on returnMode it will either
     * modify the value of $this->string and return $this
     * OR will create a new object of this class for the
     * new string and return that new object
     * Either way an object of this class is returned
     *
     * @param $string
     *
     * @return object of this class
     */
    protected function handleReturn($string)
    {

        if ('StringBuilder' !== $this->returnMode) {
            $o = new static($string, $this->returnMode);
            return $o;
        }

        $this->string = $string;

        return $this;
    }


    /**
     * A simpler implementation of linkify
     * does not do truncating of link text
     * but seems to work better for certain links
     *
     * @important DO NOT use on HTML String!
     *            for html string use HTMLStringParser::linkify()
     *
     * @return object of this class
     */
    public function linkify()
    {
        if ($this->isHtml()) {
            e('not cool to linkify this string because it is an HTML string Use \Lampcms\String\HTMLStringParser::linkify() for HTML strings');
        }

        $text = $this->string;
        $text = \preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" rel=\"nofollow\">$3</a>", $text);
        $text = \preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" rel=\"nofollow\">$3</a>", $text);

        return $this->handleReturn($text);
    }


    /**
     * Cut string of text to be not more
     * than $max chars but makes sure it cuts
     * only on word boundary
     *
     * @param int    $max
     * @param string $link
     *
     * @return object of this class
     */
    public function truncate($max, $link = '')
    {
        $words = \preg_split("/[\s]+/", $this->string);

        $newstring = '';
        $numwords  = 0;

        foreach ($words as $word) {
            if ((\strlen($newstring) + 1 + \strlen($word)) < $max) {
                $newstring .= ' ' . $word;
                ++$numwords;
            } else {
                break;
            }
        }

        if ($numwords < count($words)) {
            $newstring .= '... ' . $link;
        }

        return $this->handleReturn(\trim($newstring));
    }


    /**
     * Change the & to $amp;
     * but only if the & is not part of already encoded
     * html entity, including &amp;
     * This is most likely utf8 safe because the pattern
     * only contains valid ascii chars
     * and just in case, we also use the /u switch with
     * will make the replace fail if input contains invalid utf8 chars
     *
     * @return object of this class
     */
    public function escapeAmp()
    {
        $newstring = \preg_replace('/&(?!([#]{0,1})([a-zA-Z0-9]{2,9});)/u', '&amp;', $this->string);

        return $this->handleReturn($newstring);
    }


    /**
     * Replace non alphanumerics with underscores,
     * limit to 65 chars
     *
     * @param int $limit
     *
     * @return object of this class
     */
    public function makeLinkTitle($limit = 65)
    {
        /**
         * Remove 'a', 'the', 'an', 'i', 'you', 'we', 'it', 'is', 'are'
         */
        $aFiltered = array(
            '/ a /i',
            '/ the /i',
            '/ an /i',
            '/ i /i',
            '/ am /i',
            '/ you /i',
            '/ we /i',
            '/ it /i',
            '/ is /i',
            '/ are /i',
            '/ of /i',
            '/ i\'m /i',
            '/ it\'s /i',
            '/ of /i',
            '/ of /i',
            '/ my /i'
        );

        $str = \preg_replace($aFiltered, ' ', $this->string);

        /**
         * All non-alpha numeric chars will become dashes
         */
        $str = \preg_replace('/([^a-zA-Z0-9\-_])/', '-', $str);

        $str = \preg_replace('/(-){2,}/', '-', $str);

        /**
         * Remove the Re: type prefix
         * because it's not adding any value to
         * SEO-friendly string
         */
        $str = \preg_replace('/^re-/i', '', $str);

        /**
         * Replace anything that looks like -_ or _- with
         * just an underscore
         */
        $str = \str_replace(array('-_', '_-'), '_', $str);

        /**
         * If for some reason the string just became
         * an empty string
         * like maybe all chars were non-alpha numeric, so
         * there we all removed, then we don't want
         * to have an empty string as subject, we'll
         * just say 'topic'
         */
        if (empty($str) || ('-' === $str) || ('_' === $str)) {
            $str = 'Question';
        }

        /**
         * At this point of result string
         * is shorter than the limit, no further
         * processing is necessary, just return it
         */
        if (strlen($str) <= $limit) {

            $str = \trim($str, ' _-');

            return $this->handleReturn($str);
        }

        /**
         * Find the right-most occurrence of dash
         */
        $lastPos = \strrpos($str, '-', ($limit - strlen($str)));

        /**
         * If last occurrence of dash not found,
         * then we will cut off the string at the $limit length
         * This is a rare case when a string did not
         * have any non alphanumeric chars - like when
         * it was a continues string of over 100 chars
         */
        $lastPos = (false !== $lastPos) ? $lastPos : $limit;

        $ret = \substr($str, 0, $lastPos);

        return $this->handleReturn($ret);
    }


    /**
     * Prepare email for more comfortable type
     *
     * @param string $strAddress   email address
     *
     * @param string $strFirstName first name
     * @param string $strLastName  last name
     *
     * @return string email address string complete with first name, last name and email address
     */
    public static function prepareEmail($strAddress, $strFirstName = '', $strLastName = '')
    {
        $fn_ln     = \trim(\trim($strFirstName) . ' ' . \trim($strLastName));
        $filtered  = \htmlspecialchars($fn_ln);
        $name      = ('' !== $fn_ln) ? '"' . $filtered . '"' : '';
        $recipient = ('' !== $name) ? $name . ' <' . $strAddress . '>' : $strAddress;

        return $recipient;
    }


    public function toLowerCase()
    {
        $s = \strtolower($this->string);

        return $this->handleReturn($s);
    }


    public function toUpperCase()
    {
        $s = \strtoupper($this->string);

        return $this->handleReturn($s);
    }


    public function isEmpty()
    {
        return (0 === $this->length());
    }


    public function substr($start, $len = null)
    {
        $s = \substr($this->string, $start, $len);

        return $this->handleReturn($s);
    }


    /**
     * Apply trim() to this string with no
     * extra params passed to trim, which is UTF-8 safe
     *
     * @return object of this class
     */
    public function trim()
    {
        $s = \trim($this->string);

        return $this->handleReturn($s);
    }


}
