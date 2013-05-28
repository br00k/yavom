<? $divid = uniqid(); ?>
<?php echo  $e.'<span class="idekelleneright">'.image_tag("icons/information",array("title"=>__('Entitlement package details'), "class"=>"entitlementpackcard_button","id"=>"entitlementpackcard_button_".$divid)) ?>
<? if ($oe):?>
<? if($oe->getStatus() == "accepted"): ?>
  <?php echo  image_tag("icons/tick",array("title"=>__("Connected")))?>
  
<? else :?>
  <?php echo  image_tag("icons/hourglass",array("title"=>__("Pending")))?>
<? endif ?>
<?php echo  image_tag("icons/delete",array("title"=>__('Unlink'),
		"class" =>"organization_unlink_button button",
		"id"=>$oe->getId())) ?>
	    <? include_partial("unlinkOrganizationForm",array("epid"=>$oe->getId(),"o"=>$oe->getOrganization(),"e"=>$oe->getEntitlementPack())) ?>
<? endif ?>
 <a href="<?php echo  $e->getService()->getUrl()?>" target="_blank">
  <?php echo  image_tag("icons/link_go",array("title"=>__("Open")))?>
 </a>
<? /*= //link_to(image_tag("icons/world_link",$e->getService()->getUrl(),array("target"=>"_blank")))
<a href="<?php echo  $e->getService()->getUrl()?>" target="_blank"><?php echo  image_tag("icons/world_link") ?></a>
*/?></span><br>
<div class="entitlementpackcard" id="entitlementpackcard_<?php echo  $divid ?>">
 <div>
 <?php echo __('Service name:')?><span class="right"><?php echo  $e->getService()->getName()?></span>
 </div>
 <div>
 <?php echo __('Service homepage:')?><span class="right"><a href="<?php echo  $e->getService()->getUrl()?>" target="_blank"><?php echo  $e->getService()->getUrl()?></a></span><br>
 </div>
 <div>
 <?php echo __('Entitlement pack name:')?><span class="right"><?php echo  $e->getName() ?></span>
 <div>
 </div>
 <?php echo __('Entitlement pack description')?><span class="right"><?php echo  $e->getDescription()?></span>
 </div>
</div>
<script>
$(document).ready(function() {
        /* Jogosultságcsomag névjegye */
        $('#entitlementpackcard_button_<?php echo  $divid ?>').click(function() {
                $('#entitlementpackcard_<?php echo  $divid ?>').dialog('open');
                return false;
        });
        $('.organization_unlink').dialog({
		autoOpen: false,
		title: '<?php echo __('Withdraw entitlement package from organization')?>',
                    modal: true,
                    width: 500
		});
	$('.organization_unlink_button').click(function() {
		$('.organization_unlink[id=' + this.id + ']').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
});
</script>
