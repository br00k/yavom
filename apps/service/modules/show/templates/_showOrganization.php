<div class="organizationcard" id="organizationcard_<?php echo  $o->getId() ?>">
 <div>
 <?php echo __('Organization name:')?><span class="right"><?php echo  $o->getName() ?></span>
 </div>
 <div>
 <?php echo __('Organization description:')?><span class="right"><?php echo  $o->getDescription(ESC_RAW)?></span>
 </div>
 <div>
 <?php echo __('Service managers:')?>
 <span class="right">
 <?foreach ($o->getPrincipal() as $p) : ?>
  <?php echo  mail_to($p->getEmail(),$p->getName()) ?><br>
 <? endforeach ?>
 </span>
 </div>
</div>
<script>
$(document).ready(function() {
        /* Szervezet névjegye */
        $('#organizationcard_button_<?php echo  $o->getId() ?>').click(function() {
                $('#organizationcard_<?php echo  $o->getId() ?>').dialog('open');
                return false;
        });
});
</script>
