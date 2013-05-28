<? $divid = uniqid(); ?>
  <?php echo  $i->getEmail().image_tag("icons/hourglass",array("class"=>"invitationcard_button","id"=>"invitationcard_button_".$divid)) ?>
  <br>

<div class="invitationcard" id="invitationcard_<?php echo  $divid ?>">
 <div>
 Email:<span class="right"><?php echo  mail_to($i->getEmail(),$i->getEmail())?></span>
 </div>
 <div>
 <?php echo __('Role:')?><span class="right"><?php echo  $i->getRole()->getName() ?></span>
 </div>
 <div>
 <?php echo __('First invited:')?><span class="right"><?php echo  $i->getCreatedAt()?></span>
 </div>
 <? if ($i->getCounter() > 1 ): ?>
   <div>
   <?php echo __('Times invited:')?><span class="right"><?php echo  $i->getCounter() ?></span>
   </div>
   <div>
   <?php echo __('Last invited:')?><span class="right"><?php echo  $i->getLastReinviteAt()?></span>
   </div>
 <? endif ?>
   <div>
  <span class="right">
  <?php echo  image_tag("icons/arrow_refresh",array("title"=>__('Resend invitation'), "class"=>"reinvite","id"=>$i->getId())) ?>
  <?php echo  image_tag("icons/delete",array("title"=>__("Delete invitation"),"class"=>"delete","id"=>$i->getId())) ?>
   </span>
   </div>
</div>
<script>
$(document).ready(function() {
        /* Meghívó névjegye */
        $('#invitationcard_button_<?php echo  $divid ?>').click(function() {
                $('#invitationcard_<?php echo  $divid ?>').dialog('open');
                // prevent the default action, e.g., following a link
                return false;
        });
        $('.delete').click(function() {
            window.location.replace("<?php echo  url_for("invitePrincipal/delete?id=") ?>" + $(this).attr("id"));
        });
        $('.reinvite').click(function() {
            window.location.replace("<?php echo  url_for("invitePrincipal/reinvite?id=") ?>" + $(this).attr("id"));
        });
});
</script>
