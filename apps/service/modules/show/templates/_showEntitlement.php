<div class="entitlementcard" id="entitlementcard_<?php echo  $e->getId() ?>">
 <div>
 <?php echo __('Entitlement name:')?><span class="right"><?php echo  $e->getName() ?></span>
 </div>
 <div>
 <?php echo __('Entitlement description:')?><span class="right"><?php echo  $e->getDescription()?></span>
 </div>
 <div>
 <?php echo __('eduPersonEntitlement value:')?><span class="right"><?php echo  $e->getUri()?></span>
 </div>
</div>
<script>
$(document).ready(function() {
        /* Jogosultság névjegye */
        $('#entitlementcard_button_<?php echo  $e->getId() ?>').click(function() {
                $('#entitlementcard_<?php echo  $e->getId() ?>').dialog('open');
                return false;
        });
        $('#entitlementcard_button_2_<?php echo  $e->getId() ?>').click(function() {
                $('#entitlementcard_<?php echo  $e->getId() ?>').dialog('open');
                return false;
        });
});
</script>
