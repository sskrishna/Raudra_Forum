<?php
/**
 *
 * PHP 5.3 or better is required
 *
 * @package    Global functions
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
 *
 * @author     Dmitri Snytkine <cms@lampcms.com>
 * @copyright  2005-2012 (or current year) Dmitri Snytkine
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: 0.2.45
 *
 *
 */

class tplToptabs extends Lampcms\Template\Fast
{

    protected static function func(&$a)
    {
        $a['search'] = \tplSearchForm::parse(array('q' => ''));

    }

    protected static $vars = array(
        'questions_c' => '', //1
        'unanswered_c' => '', //2
        'tags_c' => '', //3
        'ask_c' => '', //4
        'questions' => '@@Questions@@', //5
        'unanswered' => '@@Unanswered@@', //6
        'tags' => '@@Tags@@', //7
        'ask' => '@@Ask Question@@', //8
        'search' => '', //9
        'users_c' => '', //10
        'users' => '@@Members@@' //11
    );


    protected static $tpl = '<div id="navtabs" class="doc3">
                    <ul>
                        <li class="ttab%1$s"><a id="tab-q" href="{_WEB_ROOT_}/{_viewquestions_}/">%5$s</a></li>
                        <li class="ttab%2$s"><a id="tab-un" href="{_WEB_ROOT_}/{_unanswered_}/">%6$s</a></li>
                        <li class="ttab%3$s"><a id="tab-t" href="{_WEB_ROOT_}/{_viewqtags_}/">%7$s</a></li>
                        <li class="ttab%10$s"><a id="tab-m" href="{_WEB_ROOT_}/{_users_}/">%11$s</a></li>
                        <li class="ttab%4$s"><a id="tab-ask" href="{_WEB_ROOT_}/{_askform_}/">%8$s</a></li>
                        <li class="tsearch">%9$s</li>
                    </ul>
                </div>';
}
