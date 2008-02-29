<?php

class RoxPageView extends PAppView
{
    private $_stylesheets = array();
    private $_scriptfiles = array();
    private $_words = 0;
    
    public function addScriptfile($url) {
        $_scriptfiles[] = $url;
    }
    
    public function addStylesheet($url) {
        $_stylesheets[] = $url;
    }
    
    public function render() {
        $this->_init();
        $this->_render();
        exit(0);
    }
    
    private function _init()
    {
        $this->addStylesheet('styles/YAML/main.css');
        $this->addStylesheet('styles/YAML/bw_yaml.css');
        $this->addScriptfile('script/main.js');
    }
    
    private function _render() {
        ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo PVars::get()->lang; ?>" lang="<?php echo PVars::get()->lang; ?>" xmlns:v="urn:schemas-microsoft-com:vml">
        <head>
        <?php $this->head() ?>
        </head>
        <body>
        <?php $this->body() ?>
        </body>
        </html><?php
    }
    
    private function _includeStylesheets() {
        foreach($this->_stylesheets as $url) {
            ?><link rel="stylesheet" href="<?=$url ?>" type="text/css" />
            <?php
        }
    }
    
    private function _includeScriptfiles() {
        foreach($this->_scriptfiles as $url) {
            ?><script type="text/javascript" src="<?=$url ?>"></script>
            <?php
        }
    }
    
    protected function getTopmenuItems()
    {
        $items = array();
        
        if (APP_User::isBWLoggedIn()) {
            $items[] = array('main', 'main', 'Menu');
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
            $items[] = array('profile', 'bw/member.php?cid='.$username, 'MyProfile');
        }
        $items[] = array('searchmembers', 'searchmembers/index', 'FindMembers');
        $items[] = array('forums', 'forums', 'Community');
        $items[] = array('groups', 'bw/groups.php', 'Groups');
        $items[] = array('gallery', 'gallery', 'Gallery');
        $items[] = array('getanswers', 'about', 'GetAnswers');
        
        return $items;
    }
    
    protected function getTopmenuActiveItem() {
        return 0;
    }
    
    protected function getSubmenuItems() {
        return 0;
    }
    
    protected function getSubmenuActiveItem() {
        return 0;
    }
    
    protected function head()
    {
        ?>
        <title><?=$this->getPageTitle() ?></title>
        <base id="baseuri" href="<?=PVars::getObj('env')->baseuri; ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="verify-v1" content="NzxSlKbYK+CRnCfULeWj0RaPCGNIuPqq10oUpGAEyWw=" />
        
        <link rel="stylesheet" href="styles/YAML/main.css" type="text/css" />
        <link rel="stylesheet" href="styles/YAML/bw_yaml.css" type="text/css" />
        
        <!--[if lte IE 7]>
        <link rel="stylesheet" href="styles/YAML/patches/iehacks_3col_vlines.css" type="text/css" />
        <![endif]-->
        
        <?php $this->_includeStylesheets() ?>
    
        <!--[if lt IE 7]>
        <script defer type="text/javascript" src="script/pngfix.js"></script>
        <![endif]-->
        
        <?php
        $this->_includeScriptfiles();
        $this->_tr_buffer_header = $this->getWords()->flushBuffer();
    }
    
    protected function body()
    {
        ?>
        <!-- #page_margins: Obsolete for now. If we decide to use a fixed width or want a frame around the page, we will need them aswell -->
        <div id="page_margins">
          <!-- #page: Used to hold the floats -->
          <div id="page" class="hold_floats">
            
            <div id="header">
              <div id="topnav">
                <?php $this->topnav() ?>
              </div> <!-- topnav -->
              <?php $this->logo() ?>
            </div> <!-- header -->
            
            <?php $this->topmenu() ?>
            
            <!-- #main: content begins here -->
            <div id="main">
              <?php $this->teaser() ?>
              <?php $this->columnsArea() ?>
            </div> <!-- main -->
            <?php $this->footer() ?>
            <?php $this->leftoverTranslationLinks() ?>
          </div> <!-- page -->
        </div> <!-- page_margins-->
        <?php $this->debugInfo() ?>
        </body>
        <?php
    }
    
    protected function topnav()
    {
        $words = $this->getWords();
        $logged_in = APP_User::isBWLoggedIn();
        if (!$logged_in) {
            $request = PRequest::get()->request;
            if (!isset($request[0])) {
                $login_url = 'login';
            } else switch ($request[0]) {
                case 'login':
                case 'main':
                case 'start':
                    $login_url = 'login';
                    break;
                default:
                    $login_url = 'login/'.implode('/', $request);
            }
        }
        ?><ul>
          <li><img src="styles/YAML/images/icon_grey_online.png" alt="onlinemembers" /> <a href="bw/whoisonline.php"><?php echo $words->getBuffered('NbMembersOnline', $_SESSION['WhoIsOnlineCount']); ?></a><?php echo $words->flushBuffer(); ?></li>
          <?php if ($logged_in) { ?>
          <li><img src="styles/YAML/images/icon_grey_mail.png" alt="mymessages"/><a href="bw/mymessages.php"><?php echo $words->getBuffered('Mymessages'); ?></a><?php echo $words->flushBuffer(); ?></li>
          <li><img src="styles/YAML/images/icon_grey_pref.png" alt="mypreferences"/><a href="bw/mypreferences.php"><?php echo $words->getBuffered('MyPreferences'); ?></a><?php echo $words->flushBuffer(); ?></li>
          <li><img src="styles/YAML/images/icon_grey_logout.png" alt="logout" /><a href="user/logout/<?php echo implode('/', PRequest::get()->request) ?>" id="header-logout-link"><?php echo $words->getBuffered('Logout'); ?></a><?php echo $words->flushBuffer(); ?></li>
          <?php } else { ?>
          <li><img src="styles/YAML/images/icon_grey_logout.png" alt="login" /><a href="<?php echo $login_url ?>" id="header-login-link"><?php echo $words->getBuffered('Login'); ?></a><?php echo $words->flushBuffer(); ?></li>
          <li><a href="bw/signup.php"><?php echo $words->getBuffered('Signup'); ?></a><?php echo $words->flushBuffer(); ?></li>
        <?php } ?>
        </ul>
        <?php
    }
    
    protected function logo() {
        ?><a href="start"><img id="logo" class="float_left overflow" src="styles/YAML/images/logo.gif" width="250" height="48" alt="Be Welcome" /></a>
        <?php
    }
    
    protected function topmenu()
    {
        $words = $this->getWords();
        $menu_items = $this->getTopmenuItems();
        $active_menu_item = $this->getTopmenuActiveItem();
        
        ?>
        <!-- #nav: main navigation -->
        <div id="nav">
          <div id="nav_main">
            <ul>
              <?php
        
        foreach ($menu_items as $item) {
            $name = $item[0];
            $url = $item[1];
            $wordcode = $item[2];
            if ($name === $active_menu_item) {
                $attributes = ' class="active"';
            } else {
                $attributes = '';
            }
                
              ?><li<?=$attributes ?>>
                <a href="<?=$url ?>">
                  <span><?=$words->getBuffered($wordcode); ?></span>
                </a>
                <?=$words->flushBuffer(); ?>
              </li>
              <?php
              
        }
        
            ?></ul>
            
            <!-- #nav_flowright: This part of the main navigation floats to the right. The items have to be listed in reversed order to float properly-->         
            <div id="nav_flowright">
              <?php $this->quicksearch() ?>
            </div> <!-- nav_flowright -->
          </div>
        </div>
        <!-- #nav: - end -->
        
        <?php
    }
    
    protected function quicksearch()
    {
        PPostHandler::setCallback('quicksearch_callbackId', 'SearchmembersController', 'index');
        ?>
        <form action="searchmembers/quicksearch" method="post" id="form-quicksearch">
          <input type="text" name="searchtext" size="15" maxlength="30" id="text-field" value="Search...." onfocus="this.value='';"/>
          <input type="hidden" name="quicksearch_callbackId" value="1"/>
          <input type="image" src="styles/YAML/images/icon_go.gif" id="submit-button" />
        </form>
        <?php
    }
    
    protected function columnsArea()
    {
        $columns = $this->getColumnNames();
        $i_max = count($columns)-1;
        for ($i=0; $i<$i_max; ++$i) {
            $column_name = $columns[$i];
            ?>
              <div id="<?=$column_name ?>">
                <div id="<?=$column_name ?>_content" class="clearfix">
                  <?php $this->_column($column_name) ?>
                </div> <!-- <?=$column_name ?>_content -->
              </div> <!-- <?=$column_name ?> -->
            <?php
        }
        $column_name = $columns[$i_max];
        ?>
          <div id="<?=$column_name ?>">
            <div id="<?=$column_name ?>_content" class="clearfix">
              <table class="full">
                <tr>
                  <td class="info">
                    <?php $this->_column($column_name) ?>
                  </td>
                </tr>
              </table>
            </div> <!-- <?=$column_name ?>_content -->
            <!-- IE Column Clearing -->
            <div id="ie_clearing">&nbsp;</div>
            <!-- Ende: IE Column Clearing -->
          </div> <!-- <?=$column_name ?> -->
        <?php
    }
    
    protected function getWords()
    {
        if (!$this->_words) {
            $this->_words = new MOD_words();
        }
        return $this->_words; 
    }
    
    protected function getPageTitle() {
        return 'BeWelcome';
    }
    
    protected function teaser()
    {
        ?>
        <!-- #teaser: the orange bar shows title and elements that summarize the content of the current page -->
        <div id="teaser_bg">
          <?php $this->teaserContent() ?>
          <div id="teaser_shadow">
            <?php
            
        if (!$this->getSubmenuItems()) {
            echo '<img src="styles/YAML/images/spacer.gif" width="95%" height="5px" alt="spacer" />';
        } else {
            $this->submenu();
        }
        
            ?></div> <!-- tease_shadow -->
          </div> <!-- teaser_bg -->
          <?php
    }
    
    protected function submenu()
    {
        $words = $this->getWords();
        ?>
        <div id="middle_nav" class="clearfix">
          <div id="nav_sub">
            <ul>
              <?php
        
        $active_menu_item = $this->getSubmenuActiveItem();
        foreach ($this->getSubmenuItems() as $index => $item) {
            $name = $item[0];
            $url = $item[1];
            $wordcode = $item[2];
            if ($name === $active_menu_item) {
                $attributes = ' class="active"';
            } else {
                $attributes = '';
            }
            
            ?><li id="sub<?=$index ?>" <?=$attributes ?>>
              <a style="cursor:pointer;" href="<?=$url ?>">
                <span><?=$words->getBuffered($wordcode); ?></span>
              </a>
              <?=$words->flushBuffer(); ?>
            </li>
            <?php
            
        }
        
            ?></ul>
          </div>
        </div>
        <?php
    }
    
    protected function teaserContent() {
        ?>
        Please implement<br>
        <?=get_class($this).'::teaserContent()';
    }
    
    protected function footer() {
        $Rox = new RoxController();
        $Rox->footer();
    }
    
    protected function leftoverTranslationLinks()
    {
        $tr_buffer_body = $this->getWords()->flushBuffer();
        if($this->_tr_buffer_header != '') {
            echo '<br>Remaining words in header: ' . $this->_tr_buffer_header . '<br><br>';
        }
        if($tr_buffer_body != '') {
            echo '<br>Remaining words in body: ' . $tr_buffer_body . '<br><br>';
        }
    }
    
    protected function debugInfo() {
        if (PVars::get()->debug) {
            ?>
            <!--
            Build: <?=PVars::get()->build ?>
            Templates: <?=basename(TEMPLATE_DIR) ?>
            -->
            <?php
        }
    }
    
    protected function getPermalink() {
        return 'index';
    }
    
    protected function getColumnNames() {
        return array('col1', 'col2', 'col3');
    }
    
    private function _column($column_name)
    {
        $method_name = 'column_'.$column_name;
        if (!method_exists($this, $method_name)) {
            echo 'please implement<br>'.get_class($this).'::'.$method_name.'()';
        } else {
            $this->$method_name();
        }
    }
}


?>