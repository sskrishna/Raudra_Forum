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

/**
 * Template generates tabs
 * for sorting answers in the Question view
 * by Recent, Oldest or Voted
 *
 * @author admin
 *
 */
class tplAnstypes extends Lampcms\Template\Fast
{
    protected static $vars = array(

        'recent_c' => '', // 1
        'best_c' => '', //2

        'i_lm_ts' => '@@Active@@', //3
        'i_lm_ts_t' => '@@Answers with latest activity first@@', //4

        'i_votes' => '@@Best@@', //5
        'i_votes_t' => '@@Best answers first@@', //6

        'oldest_c' => '', //7
        'i_ts' => '@@Oldest@@', // 8
        'i_ts_t' => '@@Answers in the order they were submitted@@' // 9

    );

    protected static $tpl = '
	<div id="qtypes" class="sorttab cb fl reveal hidden">
		<a id="sort_{_SORT_RECENT_}" href="#" class="ajax sortans qtype%1$s ttt2" title="%4$s"><span rel="in">%3$s</span></a>
		<a id="sort_{_SORT_BEST_}" href="#" class="ajax sortans qtype%2$s ttt2" title="%6$s"><span rel="in">%5$s</span></a>
		<a id="sort_{_SORT_OLDEST_}" href="#" class="ajax sortans qtype%7$s ttt2" title="%9$s"><span rel="in">%8$s</span></a>
	</div>';
}
