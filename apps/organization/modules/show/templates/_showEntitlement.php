<? $divid = uniqid(); ?>
<?php echo  $e.'<span class="idekelleneright">'.image_tag("icons/information",array("class"=>"entitlementcard_button","id"=>"entitlementcard_button_".$divid)) ?>
<? //= //link_to(image_tag("icons/world_link",$e->getService()->getUrl(),array("target"=>"_blank")))?>
<a href="<?php echo  $e->getService()->getUrl()?>" target="_blank"><?php echo  image_tag("icons/world_link") ?></a>
</span><br>
<div class="entitlementcard" id="entitlementcard_<?php echo  $divid ?>">
 <div>
 <?php echo __('Service name:')?><span class="right"><?php echo  $e->getService()->getName()?></span>
 </div>
 <div>
 <?php echo __('Service homepage:')?><span class="right"><a href="<?php echo  $e->getService()->getUrl()?>" target="_blank"><?php echo  $e->getService()->getUrl()?></a></span><br>
 </div>
 <div>
 <?php echo __('Entitlement name:')?><span class="right"><?php echo  $e->getName() ?></span>
 <div>
 </div>
 <?php echo __('Entitlement description:')?><span class="right"><?php echo  $e->getDescription()?></span>
 </div>
</div>
<script>
$(document).ready(function() {
        /* Jogosultság névjegye */
        $('#entitlementcard_button_<?php echo  $divid ?>').click(function() {
                $('#entitlementcard_<?php echo  $divid ?>').dialog('open');
                return false;
        });
});
</script>
