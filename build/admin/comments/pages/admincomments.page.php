<?php
/*
Copyright (c) 2007-2009 BeVolunteer

This file is part of BW Rox.

BW Rox is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BW Rox is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/> or 
write to the Free Software Foundation, Inc., 59 Temple Place - Suite 330, 
Boston, MA  02111-1307, USA.
*/
    /** 
     * @author Fake51
     */

    /** 
     * comments overview page
     * 
     * @package Apps
     * @subpackage Admin
     */

class AdminCommentsPage extends AdminBasePage
{
    private $_subset2Teaser = array(
        "all" => "All Comments",
        "abusive" => "Abusive Comments",
        "negative" => "Negative Comments",
        "from" => "User Comments",
        "to" => "User Comments",
        "single" => "Edit Comment"
    );
    
    private $teaser = "";

    protected $subset;
    
    private $words;

    protected $action;
    
    protected $scope;
    
    public function __construct($model)
    {
        parent::__construct($model);
        $this->words = new MOD_words();
        $this->scope = $this->rights['Comments']['Scope'];
    }
    
    public function setSubset($subset)
    {
        $this->teaser = $this->_subset2Teaser[$subset];
        if($this->teaser=="")
        {
            // TODO: throw exception
            echo "Unsupported subset: " . $subset;
        }
        $this->subset = $subset;
    }

    public function teaserHeadline()
    {
        return "<a href='admin'>{$this->words->get('AdminTools')}</a> &raquo; <a href='admin'>{$this->teaser}</a>";
    }

    protected function displayInPublic($f)
    {
        return ($f ? "Hide" : "Show");
    }

    protected function allowEdit($f)
    {
        return ($f ? "Default Editing" : "Allow Editing");
    }

    protected function getProximityBlock($sel)
    {
        $selected = explode(",", $sel);
        $proximityBlock = "";
        $syshcvol = PVars::getObj('syshcvol');
        foreach ($syshcvol->LenghtComments as $proximity)
        {
            $proximityBlock .= "<input type=\"checkbox\" name=\"" . $proximity . "\" " .
                (in_array($proximity, $selected)?"checked=\"checked\" ":"") .
                "/>" . $this->words->get("Comment_" . $proximity) . 
                "<br/>\n";
        }
        return $proximityBlock;
    }
    
    protected function getQualityBlock($q)
    {
        $s = "background-color:lightgreen;";
        if($q=="Neutral")
            $s = "background-color:lightgray;";
        elseif($q=="Bad")
            $s = "background-color:red;color:white;";
        
        return
        '<select name="Quality" style="' . $s . '">
        <option value="Neutral"' . 
                ($q=="Neutral" ? " selected=\"selected\"" : "") . 
                '>' . $this->words->get("CommentQuality_Neutral") . '</option>
        <option value="Bad"' .
                ($q=="Bad" ? " selected=\"selected\" style=\"background-color:red;color:white;\"" : "") .
                '>' . $this->words->get("CommentQuality_Bad") . '</option>
        <option value="Good"' .
                ($q=="Good" ? " selected=\"selected\" style=\"background-color:lightgreen;\"" : "") .
                '>' . $this->words->get("CommentQuality_Good") . '</option>
        </select>';
    }
    
    // TODO: unnecessary to have this here; layoutbits are available via $this-> in the template
    // context, see adminrightsreate.column_col3.php - and build similar logic then!
    public function getCallbackTags()
    {
        $layoutbits = new MOD_layoutbits;
        $formkit = $this->layoutkit->formkit;
        $callback_tag = $formkit->setPostCallback('AdminCommentsController', 'updateCallback');
        return $callback_tag;
    }
}
