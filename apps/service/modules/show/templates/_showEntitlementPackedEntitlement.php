<? $divid = uniqid(); ?>
<?php echo  $e.'<span class="idekelleneright">'.image_tag("icons/information",array("title"=>__('Entitlement details'), "class" =>"entitlementcard_button", "id"=>"entitlementcard_button_".$e->getId())); ?>
<br>
<div class="entitlementpackcard" id="entitlementpackcard_<?php echo  $divid ?>">
 <div>
 <?php echo __('Service name:')?><span class="right"><?php echo  $e->getService()->getName()?></span>
 </div>
 <div>
 <?php echo __('Entitlement pack name:')?><span class="right"><?php echo  $e->getName() ?></span>
 </div>
</div>
<script>
$(document).ready(function() {
        /* Szereplő névjegye */
        $('#entitlementpackcard_button_<?php echo  $divid ?>').click(function() {
                $('#entitlementpackcard_<?php echo  $divid ?>').dialog('open');
                // prevent the default action, e.g., following a link
                return false;
        });
});
</script>

