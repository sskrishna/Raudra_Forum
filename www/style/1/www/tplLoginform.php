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
 * Template of the login form
 *
 * @author Dmitri Snytkine
 *
 */
class tplLoginform extends Lampcms\Template\Fast
{

    protected static $vars = array(
        'error' => ''
    );

    protected static $tpl = '<div class="fl uwelcome"><form action="{_WEB_ROOT_}/" method="post" name="frmLogin" id="frmLogin">
<input name="_qf__frmLogin" type="hidden" value="">
<input name="a" type="hidden" value="login">
<input name="r" type="hidden" value="@@Username@@">
<table id="toplogin" cellspacing="2" cellpadding="2">
<tr>
	<td colspan="3" align="center">
		<div class="titleWarning" id="titleWarning">%1$s</div>
	</td>
</tr>

<!--<tr>
	<td><label for="log">@@Username@@</label></td>
    <td><label for="pwd">@@Password@@</label></td>
</tr>-->

<tr>
    <td>
		<input type="text" class="inlogin" name="login" id="log" size="15" accesskey="u" tabindex="1" placeholder="username">
	</td>
	<td>
	  <input type="password" name="pwd" class="inpwd" id="pwd" size="10" tabindex="4" placeholder="password">
	</td>
    <td align="left"> 
      <input class="dologin" value="@@Log in@@" type="submit">
    </td>
	<td><div class="fl cb">
			<div class="fl btnjoin" id="joinus">
				<a id="asignup" href="{_WEB_ROOT_}/{_register_}/">@@Sign up@@</a>
			</div>
	</td>

</tr>
	<!--<tr><td>&nbsp;</td></tr>-->
<tr>
    <td align="left" nowrap="nowrap"><label for="chkRemember">
		<input name="chkRemember" type="checkbox" value="3" id="chkRemember">@@Do Remember@@&nbsp;</label>
	</td>
	<td colspan="2" align="left" class="tdforgot">
     <a href="{_WEB_ROOT_}/{_remindpwd_}/" class="forgot">@@Forgot password?@@</a>
     </td>
</tr>

<!--new code added here -->
<tr>
	
</tr>
<!--delete the new code till here-->

</table>
</form>



</div>';

}
