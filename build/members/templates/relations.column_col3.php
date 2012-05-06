<?php
// If Delete was pressed
if (isset($_GET['delete']) && isset($_GET['IdRelation'])) {
    $vars['confirm'] = 'No';
    $vars['IdOwner'] = $_SESSION['IdMember'];
    $vars['IdRelation'] = $_GET['IdRelation'];
    $this->model->deleteRelation($vars);
}

$words = new MOD_words();
$member = $this->member;
$relations = $member->relations;
$username = $member->Username;
$myself = $this->myself;

?>
<h3><?php echo $words->get('MyRelations'); ?></h3>

<ul class="linklist">
<?php
foreach ($relations as $rel) {
    require 'relation_item.php';
}
?>
</ul>
