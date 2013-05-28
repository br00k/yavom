<? $me = $sf_user->getGuardUser()->getUserName() == $p->getFedid(); ?>
<? $divid = uniqid(); ?>
  <? if ($p->getUser()) :?>
     <? echo $me?'<span style="background: #ADA;">':"" ?>
     <?php echo  $p->getName() ?>
     <?php echo  image_tag("icons/information",array("class"=>"namecard_button","id"=>"namecard_button_".$divid)) ?>
     <?php echo  $i?image_tag("icons/delete",array("class"=>"unlinkprincipal_button","id"=>"unlinkprincipal_button_".$divid)):"" ?>
     <? //= $i?$i->getId():"" ?>
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
</div>

<? if ($i) :?>
<div class="unlinkprincipal" id="unlinkprincipal_<?php echo  $divid ?>">
 <div>
 <?php echo __('Name:')?><span class="right"><?php echo  $p->getName()?></span>
 </div>
 <div>
 <?php echo __('Federal ID:')?><span class="right"><?php echo  $p->getFedid()?></span>
 </div>
</div>
<? endif ?>

<script>
$(document).ready(function() {
        /* Szereplő névjegye */
        $('#namecard_button_<?php echo  $divid ?>').click(function() {
                $('#namecard_<?php echo  $divid ?>').dialog('open');
                // prevent the default action, e.g., following a link
                return false;
        });
<? if ($i) :?>

        /* Szereplő kizárása */
        $('#unlinkprincipal_<?php echo  $divid ?>').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Expel principal')?>',
                buttons: {
			"<?php echo __('Cancel')?>": function() {
				$( this ).dialog( "close" );
			},
			"<?php echo __('Delete')?>": function() {
                                $(location).attr('href','<?php echo  url_for("show/unlinkPrincipal?id=".$i->getId()) ?>');
				}
		}
	});
        $('#unlinkprincipal_button_<?php echo  $divid ?>').click(function() {
                $('#unlinkprincipal_<?php echo  $divid ?>').dialog('open');
                // prevent the default action, e.g., following a link
                return false;
        });
<? endif ?>
});
</script>

     <? else :?>
         <?php echo  $p.image_tag("icons/error",array("class"=>"not_linked_principal")) ?>
     <br>
     <? endif ?>
