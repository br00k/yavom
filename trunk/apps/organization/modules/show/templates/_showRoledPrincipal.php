<? //$p = $rp->getPrincipal()?>
<? $p = $rp?>
<? $me = $sf_user->getGuardUser()->getUserName() == $p->getFedid(); ?>
<? $divid = uniqid(); ?>
  <? if ($p->getUser()) :?>
     <? //= $p->getName().", ".$rp->showExpiration()." ".image_tag("icons/information",array("class"=>"namecard_button","id"=>"namecard_button_".$divid)) ?>
     <? echo $me?'<span style="background: #ADA;">':"" ?>
     <?php echo  $p->getName()." ".image_tag("icons/information",array("class"=>"namecard_button","id"=>"namecard_button_".$divid)) ?>
     <? echo $me?'</span>':"" ?>
     <br>

<div class="namecard" id="namecard_<?php echo  $divid ?>">
 <div>
 <?php echo __('Name:')?><span class="right"><?php echo  $p->getName()?></span>
 </div>
 <div>
 Email:<span class="right"><?php echo  mail_to($p->getEmail(),$p->getEmail())?></span>
 </div>
 <div>
 <?php echo __('Federal ID:')?><span class="right"><?php echo  $p->getFedid()?></span>
 </div>
 <!-- div>
 A szerep lejárati dátuma:<span class="right"><? //= $rp->showExpiration()?></span>
 </div-->
</div>
<script>
$(document).ready(function() {
        /* Szereplő névjegye */
        $('#namecard_button_<?php echo  $divid ?>').click(function() {
                $('#namecard_<?php echo  $divid ?>').dialog('open');
                // prevent the default action, e.g., following a link
                return false;
        });
});
</script>

     <? else :?>
         <?php echo  $p.image_tag("icons/error",array("class"=>"not_linked_principal")) ?>
     <br>
     <? endif ?>
