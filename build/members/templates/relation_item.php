<li class="floatbox">
  <span class="float_left">
    <a href="<?php echo PVars::getObj('env')->baseuri . "members/" . $rel->Username; ?>" title="See profile <?php echo $rel->Username; ?>">
      <img class="framed" src="members/avatar/<?php echo $rel->Username; ?>?xs" height="50px" width="50px" alt="Profile">
    </a>
  </span>
  <a href="<?php echo PVars::getObj('env')->baseuri."members/" . $rel->Username; ?>" ><?php echo $rel->Username; ?></a><br />
  <?php echo $rel->Comment; ?>
<?php if ($myself): ?>
  <br />
  <a class="button" href="<?php echo PVars::getObj('env')->baseuri . "members/" . $username . "/relations?delete&IdRelation=".$rel->id; ?>" onclick="return confirm('Are you sure?');"><?php echo $words->get('Delete'); ?></a>
<? endif; ?>
</li>
