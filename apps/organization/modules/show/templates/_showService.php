<? $divid = uniqid(); ?>
<?php echo  $s.'<span class="idekelleneright">'.image_tag("icons/information",array("class"=>"servicecard_button","id"=>"servicecard_button_".$divid)) ?>
<? if ($os and $os->getStatus() == "accepted"): ?>
  <?php echo  image_tag("icons/tick",array("title"=>"Kapcsolva"))?>
<? else :?>
  <?php echo  image_tag("icons/hourglass",array("title"=>"Függőben"))?>
<? endif ?>
 <a href="<?php echo  $s->getUrl()?>" target="_blank">
  <?php echo  image_tag("icons/link_go",array("title"=>"Megnyitás"))?>
 </a>
</span>
<br>
<div class="servicecard" id="servicecard_<?php echo  $divid ?>">
 <div>
 Szolgáltatás neve:<span class="right"><?php echo  $s->getName()?></span>
 </div>
 <div>
 Szolgáltatás főoldala:<span class="right"><a href="<?php echo  $s->getUrl()?>" target="_blank"><?php echo  $s->getUrl()?></a></span><br>
 </div>
 <div>
 Szolgáltatás gazdája:<span class="right"><?php echo  mail_to($s->getPrincipal()->getEmail(),$s->getPrincipal()->getName())?></span><br>
 </div>
</div>
<script>
$(document).ready(function() {
        /* Jogosultság névjegye */
        $('#entitlementpackcard_button_<?php echo  $divid ?>').click(function() {
                $('#servicecard_<?php echo  $divid ?>').dialog('open');
                return false;
        });
});
</script>
