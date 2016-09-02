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
 * Class of type HttpRequest
 * extends HttpRequest class
 * and implements several custom functions
 * to better handle timeout condition
 * and to throw specific exceptions
 * based on response codes
 *
 * @deprecated
 *
 * @author Dmitri Snytkine <cms@lampcms.com>
 *
 */
class Http extends \HttpRequest
{


    /**
     * Default values for
     * timeout: 8 seconds
     * useragent: Mozilla
     *
     * These can be overritten in getDocument in third param
     * // used to also include this 'redirect' => 2,
     * but now cannot include redirect limit because
     * we handle redirects separately
     *
     * @var array
     */
    protected $aOptions = array('timeout' => 10,
        'useragent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.4) Gecko/20091016 Firefox/3.5.4 GTB5');

    /**
     * Main method to get (retreive) the document from url
     * as well as set the $this object with values
     * This method makes use of special cache-control
     * request headers: If-Modified-Since
     * and If-None-Match
     *
     * @param string $url URI from which we requesting the document
     *
     * @param string $since value to use for the If-Modified-Since
     * this should be in the rfs 2822 or 822 date/time format
     * Ideally (really strongly recommended) this value should be
     * previously received from the same http server from which
     * we are currently requesting the document. It is usually
     * important that the time is in the timezone of the server
     * from which we requesting the document
     *
     * @param string $etag value to be used for the
     * If-None-Match header. This should be the value previously
     * received from the same http server for the same document
     * that we currently requesting
     *
     * @param array $aOptions
     *
     * @return object $this
     *
     * @throws Exceptions are based on returned response code:
     * 304, 404 and timeout result in special corresponding exceptions
     *
     *
     */
    public function getDocument($url, $since = null, $etag = '', array $aOptions = array())
    {

        $aHeaders = array();

        if (false === $this->setUrl($url)) {
            throw new \HttpException('Unable to set url: ' . $url);

        }

        if (!empty($aOptions)) {
            $this->aOptions = array_merge($this->aOptions, $aOptions);
        }

        $this->setOptions($this->aOptions);

        if (null !== $since) {

            $aHeaders['If-Modified-Since'] = $since;
        }

        if (!empty($etag)) {

            $aHeaders['If-None-Match'] = $etag;
        }

        if (!empty($aHeaders)) {
            $this->setHeaders($aHeaders);
        }

        try {

            $this->send();

            $intCode = (int)$this->getResponseCode();

        } catch (\HttpException $e) {
            $m = (isset($e->innerException)) ? $e->innerException->getMessage() : $e->getMessage();

            /**
             * Is this a timeout?
             */
            if (stristr($m, 'timed out') || stristr($m, 'timeout')) {
                throw new HttpTimeoutException('Timeout occured ' . $m);
            }

            /**
             * If it was not a timeout then re-throw
             * the same exception
             */
            throw $e;
        }

        switch ($intCode) {

            case 200:
                $body = $this->getResponseBody();

                if (!empty($body)) {

                    return $this;
                }

                $ex = new HttpEmptyBodyException('Empty body');
                break;

            case 301:
            case 302:
            case 303:
            case 307:
                if ('' !== $newLocation = $this->getHeader('Location')) {
                    d('redirect contains location: ' . $newLocation . ' $intCode: ' . $intCode);

                    $ex = new HttpRedirectException($newLocation, $intCode);
                } else {
                    $ex = new HttpResponseErrorException('Error ' . $intCode . ' message: ' . $this->getResponseStatus());
                }
                break;

            case 304:
                $ex = new Http304Exception('Content has not changed');
                break;

            case 401:
                $ex = new Http401Exception('Unauthorized login: ' . $url);
                break;

            case 404:
                $ex = new Http404Exception('page not found at this url: ' . $url);
                break;

            default:

                if ($intCode >= 400 && $intCode < 500) {
                    $ex = new Http400Exception('Error ' . $intCode . ' message: ' . $this->getResponseStatus(), $intCode);
                } elseif ($intCode >= 500 && $intCode < 600) {
                    $ex = new Http500Exception('Error ' . $intCode . ' message: ' . $this->getResponseStatus(), $intCode);
                } else {
                    $ex = new HttpResponseErrorException('Error ' . $intCode . ' message: ' . $this->getResponseStatus());
                }

        }

        throw $ex;
    }

    /**
     * Add specific option to
     * array of already existing options
     * Can also override an already existing option
     * by just setting the option with the same name
     * as an already existing one
     *
     * @param string $name option name
     * @param mixed $val string or array
     * @return object $this
     */
    public function setOption($name, $val)
    {
        $this->aOptions[$name] = $val;

        return $this;
    }

    /**
     * Same as getHeader from parent class
     * except that in case the header value is not found
     * the empty string is returned instead of bool false
     *
     * @param string $sHeader name of header
     * we looking for
     *
     * @return string value of header or empty string
     * if this header not found
     */
    public function getHeader($sHeader)
    {
        $val = $this->getResponseHeader($sHeader);

        return (string)$val;
    }

    /**
     * Returns value of Last-Modified header
     * OR 'Date' header
     * OR convert unix timestamp to date('r')
     *
     * @return string in the RFC 2822 date format
     */
    public function getLastModified()
    {
        $aHeaders = $this->getResponseHeader();
        if (!empty($aHeaders['Last-Modified'])) {

            return $aHeaders['Last-Modified'];

        } elseif (!empty($aHeaders['Date'])) {

            return $aHeaders['Date'];
        }

        return date('r');
    }


    /**
     * @return string value of 'Etag' header or empty string
     * if Etag is not present
     */
    public function getEtag()
    {

        return $this->getHeader('Etag');
    }

    /**
     * Get value of charset
     * as extracted from the
     * Content-Type header
     * Some servers have this info for the text content
     * like html or xml or other type of text, but
     * not all servers.
     * So this value may not be available all the time,
     * in which case the return value will be null
     *
     * @return mixed value of charset or null if not
     * available.
     *
     */
    public function getCharset()
    {
        $contentType = $this->getHeader('Content-Type');
        if (!empty($contentType) && preg_match('/charset=([\S]+)/', $contentType, $matches)) {

            return trim($matches[1]);
        }

        return null;
    }

}
