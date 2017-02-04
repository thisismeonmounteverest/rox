<div id="groups">

    <div class="row mt-2">
            <div class="col-12 col-md-6">
                    <h3><?= $words->get('GroupsSearchHeading'); ?></h3>
                    <form action="groups/search" method="get">
                        <input type="text" name="GroupsSearchInput" value="" id="GroupsSearchInput" /><input type="submit" class="button" value="<?= $words->getSilent('GroupsSearchSubmit'); ?>" /><?=$words->flushBuffer()?><br />
                    </form>
            </div>
            <div class="col-12 col-md-6">
                    <h3><?= $words->get('GroupsCreateHeading'); ?></h3>
                    <p><?= $words->get('GroupsCreateDescription'); ?></p>
                    <a class="button" role="button" href="groups/new"><span><?= $words->get('GroupsCreateNew'); ?></span></a>
            </div>
    </div>

    <div class="row mt-2">
        <div class="col-12"><h3><?= $words->get('GroupsSearchResult'); ?></h3></div>
        <div class="col-12">
        <?php
        $search_result = $this->search_result;

        $this->pager->render();

        if ($search_result) :
            $act_order = (($this->result_order == "actdesc") ? 'actasc' : 'actdesc');
            $name_order = (($this->result_order == "nameasc") ? 'namedesc' : 'nameasc');
            $member_order = (($this->result_order == "membersdesc") ? 'membersasc' : 'membersdesc');
            $created_order = (($this->result_order == "createdasc") ? 'createddesc' : 'createdasc');
            $category_order = (($this->result_order == "categoryasc") ? 'categorydesc' : 'categoryasc');
            ?>
            <p><strong><?php echo $words->get('GroupsSearchOrdered');?>:</strong> <?php echo $words->get('GroupsSearchOrdered' . $this->result_order)?>&nbsp;&nbsp;&nbsp;
            <strong><?= $words->get('GroupsSearchOrder');?></strong>
            <a class="grey" href="groups/search?GroupsSearchInput=<?=$this->search_terms;?>&order=<?=$act_order;?>&<?=$this->pager->getActivePageMarker();?>"><?= $words->get('GroupsOrderBy' . $act_order); ?></a>
            |
            <a class="grey" href="groups/search?GroupsSearchInput=<?=$this->search_terms;?>&order=<?=$name_order;?>&<?=$this->pager->getActivePageMarker();?>"><?= $words->get('GroupsOrderBy' . $name_order); ?></a>
            |
            <a class="grey" href="groups/search?GroupsSearchInput=<?=$this->search_terms;?>&order=<?=$member_order;?>&<?=$this->pager->getActivePageMarker();?>"><?= $words->get('GroupsOrderBy' . $member_order); ?></a>
            |
            <a class="grey" href="groups/search?GroupsSearchInput=<?=$this->search_terms;?>&order=<?=$created_order;?>&<?=$this->pager->getActivePageMarker();?>"><?= $words->get('GroupsOrderDate' . $created_order); ?></a></p>
        </div>
            <?
// Categories link disabled until we have categories
//            |
//            <a class="grey" href="groups/search?GroupsSearchInput={$this->search_terms}&amp;Order={$category_order}&Page={$this->result_page}">Category</a>

            echo <<<HTML
<div class="d-flex align-content-stretch flex-wrap">
HTML;
            foreach ($search_result as $group_data) :

                ?>

            <div class="d-flex flex-row m-2">
                <div>
                    <!-- group image -->
                    <a href="groups/<?=$group_data->getPKValue() ?>">
                        <img class="framed"  width="80px" height='80px' alt="group" src="<?= ((strlen($group_data->Picture) > 0) ? "groups/thumbimg/{$group_data->getPKValue()}" : 'images/icons/group.png' ) ?>"/>
                    </a>
                </div>
                <div>
                    <!-- group name -->
                    <h4><a href="groups/<?=$group_data->getPKValue() ?>"><?=htmlspecialchars($group_data->Name, ENT_QUOTES) ?></a></h4>
                    <!-- group details -->
                    <ul>
                        <li><?= $words->get('GroupsMemberCount');?>: <?=$group_data->getMemberCount(); ?></li>
                        <li><?= $words->get('GroupsDateCreation');?>: <?=date($words->getBuffered('DateHHMMShortFormat'), ServerToLocalDateTime(strtotime($group_data->created), $this->getSession())); ?></li>
                        <?php if ($group_data !== 0) {?>
                            <li><?php
                                if ($group_data->latestPost) {
                                    echo $words->get('GroupsLastPost') . ": " . date($words->getBuffered('DateHHMMShortFormat'), ServerToLocalDateTime($group_data->latestPost, $this->getSession()));
                                } else {
                                    echo $words->get('GroupsNoPostYet');
                                }
                                ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

                <?php
            endforeach ;
 ?>
    </div> <!-- end row -->
    <?php
    $this->pager->render();
    ?>
    <?php else :
        echo <<<HTML
            <p class="note">
            {$words->get('GroupSearchNoResults')}
            </p>
HTML;
    endif;
    ?>
</div> <!-- groups -->
