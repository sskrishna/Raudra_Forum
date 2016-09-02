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


namespace Lampcms\Controllers;

use \Lampcms\Responder;
use \Lampcms\WebPage;
use \Lampcms\Request;


/**
 * Controller for processing a vote
 * for question or answer
 *
 * @todo   require post and token
 *         send via Ajax by post only!
 *         Otherwise it's too easy to fake a vote
 *         by simple script tag on external website
 *         at the very least require a token and validate it!
 *         This will work even with get request
 *
 * @author Dmitri Snytkine
 *
 */
class Vote extends WebPage
{

    /**
     * Flag passed in request indicated up vote
     */
    const VOTE_UP = 'up';

    /**
     * Flag passed in request indicates the down vote
     */
    const VOTE_DOWN = 'down';

    /**
     * Must be logged in in order to vote
     *
     * @var bool
     */
    protected $membersOnly = true;

    /**
     * Permission required for being able to vote
     *
     * @var string
     */
    protected $permission = 'vote';


    /**
     * @var int id of question or answer being voted on
     */
    protected $resID;

    /**
     * Resource receiving a vote
     * This could be a object of Question or Answer class
     *
     * @var object
     */
    protected $Resource;

    /**
     * What is the vote for: QUESTION or ANSWER?
     * Default is QUESTION
     *
     * @var string
     */
    protected $resType = 'QUESTION';

    /**
     * Type of vote (up or down)
     *
     * @var string can be 'up' or 'down'
     */
    protected $voteType;


    /**
     * By how much to increment the up/down vote
     * this is either 1 or -1
     *
     * @var int
     */
    protected $inc = 1;


    protected function main()
    {
        $this->Registry->registerObservers('INPUT_FILTERS');
        $this->resID    = (int)$this->Router->getNumber(1);
        $this->voteType = $this->Router->getSegment(2);
        $this->resType  = ('a' === $this->Router->getSegment(3, 's', 'q')) ? 'ANSWERS' : 'QUESTIONS';

        if (!in_array($this->voteType, array(self::VOTE_UP, self::VOTE_DOWN))) {
            throw new \Lampcms\Exception('Invalid type of vote');
        }

        try {
            $this->getResource()
                ->postBeforeEvent()
                ->checkIsOwner()
                ->getIncrementValue()
                ->increaseVoteCount()
                ->updateQuestion()
                ->setOwnerReputation()
                ->postEvent();
        } catch ( \Exception $e ) {
            d('Vote not counted due to exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ' line: ' . $e->getLine());
        }

        $this->handleReturn();
    }


    /**
     *
     * Post onBeforeVote event
     * and allow observer to cancel event
     *
     * @throws \Lampcms\Exception
     * @return object $this
     */
    protected function postBeforeEvent()
    {
        $notification = $this->Registry->Dispatcher->post($this->Resource, 'onBeforeVote', array('type' => $this->voteType));
        if ($notification->isNotificationCancelled()) {
            throw new \Lampcms\Exception('Cancelled onBeforeVote event');
        }

        return $this;
    }


    /**
     *
     * Post onNewVote event
     *
     * @return object $this
     */
    protected function postEvent()
    {

        $this->Registry->Dispatcher->post($this->Resource, 'onNewVote', array('type'   => $this->voteType,
                                                                              'isUndo' => (1 === $this->inc)));

        return $this;
    }


    /**
     * Instantiate the resource object
     *
     * @throws \Lampcms\Exception
     * @return object $this
     */
    protected function getResource()
    {
        $a = $this->Registry->Mongo->getCollection($this->resType)
            ->findOne(array('_id' => $this->resID));

        if (empty($a) || empty($a['_id'])) {
            throw new \Lampcms\Exception('@@Invalid question or answer id@@ ' . $this->resID);
        }

        $class = ('QUESTIONS' === $this->resType) ? '\\Lampcms\\Question' : '\\Lampcms\\Answer';

        $this->Resource = new $class($this->Registry, $a);
        d('$this->Resource: ' . $this->Resource->getClass());

        return $this;
    }


    /**
     * Check if viewer is owner of resource
     * users not allowed to vote for their own
     * question
     *
     * @throws \Lampcms\Exception
     * @return object $this
     */
    protected function checkIsOwner()
    {

        if (\Lampcms\isOwner($this->Registry->Viewer, $this->Resource)) {
            throw new \Lampcms\Exception('@@Cannot rate own questions or answers@@');
        }

        return $this;
    }


    /**
     * Get the value of increment
     * this will be either 1 or -1 in case of
     * undo a vote
     *
     * @return object $this
     */
    protected function getIncrementValue()
    {

        $coll = $this->Registry->Mongo->getCollection('VOTES');
        $coll->ensureIndex(array('i_uid' => 1));
        $coll->ensureIndex(array('i_res' => 1));


        $uid   = $this->Registry->Viewer->getUid();
        $aData = array(
            'i_uid' => $uid,
            'i_res' => $this->resID,
            't'     => $this->voteType);

        $aRes = $coll->findOne($aData);

        d('$aRes: ' . \print_r($aRes, 1));

        /**
         * If record exists, then this is an 'unvote'
         * in which case we must delete the record
         * and return
         */
        if ($aRes && !empty($aRes['_id'])) {
            $this->inc = -1;
            $coll->remove(array('_id' => $aRes['_id']));
        } else {
            $aData['i_ts']    = time();
            $aData['i_owner'] = $this->Resource->getOwnerId();
            $coll->insert($aData);
        }

        return $this;
    }


    /**
     * Increase or decrease owner's reputation
     * after his question or answer receives a vote
     *
     * @return object $this
     */
    protected function setOwnerReputation()
    {

        $uid = $this->Resource->getOwnerId();
        d('uid of resource owner: ' . $uid);
        /**
         * Now need to calculate points
         *
         */
        try {
            \Lampcms\User::userFactory($this->Registry)->by_id($uid)
                ->setReputation($this->calculatePoints())
                ->save();
        } catch ( \Exception $e ) {
            e($e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine());
        }

        return $this;
    }


    /**
     *
     * Calculate points
     * This would depend on
     * Upvote/Downvote
     * Is Undo
     * Resource type: Q or A
     *
     * @return int
     */
    protected function calculatePoints()
    {
        if (self::VOTE_DOWN === $this->voteType) {
            $points = $this->Registry->Ini->POINTS->DOWNVOTE;
        } elseif ('QUESTION' === $this->resType) {
            $points = $this->Registry->Ini->POINTS->UPVOTE_Q;
        } else {
            $points = $this->Registry->Ini->POINTS->UPVOTE_A;
        }

        $points = ($this->inc * $points);
        d('$points: ' . $points);

        return $points;
    }


    /**
     * Increment value of i_up/i_down of question/answer
     *
     * @return object $this
     */
    protected function increaseVoteCount()
    {
        if (self::VOTE_UP === $this->voteType) {
            $this->Resource->addUpVote($this->inc)->touch(true);
        } else {
            $this->Resource->addDownVote($this->inc)->touch(true);
        }

        return $this;
    }


    /**
     * If vote was on the ANSWER
     * we still need to update i_lm_ts of question
     * to prevent browser displaying cached version
     *
     * @return object $this
     */
    protected function updateQuestion()
    {
        if ('ANSWERS' === $this->resType) {
            try {
                $this->Registry->Mongo->QUESTIONS
                    ->update(
                    array('_id' => $this->Resource['i_qid']),
                    array('$set' =>
                          array('i_etag' => time())));

            } catch ( \Exception $e ) {
                e('unable to update question after vote for answer is received ' . $this->Resource['i_qid']);
            }
        }

        return $this;
    }


    /**
     * Send response to browser
     * In case of Ajax request send back json encoded array
     * In case of non-ajax redirect back to Question or Answer page
     *
     */
    protected function handleReturn()
    {
        $isAjax = Request::isAjax();
        d('$isAjax: ' . $isAjax);

        if ($isAjax) {
            $ret = array(
                'vote' => array(
                    'v'   => $this->Resource->getScore(),
                    't'   => $this->resType,
                    'rid' => $this->resID)
            );

            Responder::sendJSON($ret);

        }

        Responder::redirectToPage($this->Resource->getUrl());

    }
}