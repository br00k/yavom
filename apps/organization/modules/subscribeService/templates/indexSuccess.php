<h2><?php echo __('Subscribe to a service'); ?></h2>
<? foreach($oe as $e) :?>
 <?php echo  link_to(image_tag("icons/cog_go", array("title"=>"Feliratkozás", "class"=>"button")),"subscribeService/subscribe?from=".$sf_user->getPrincipal()->getId()."&eid=".$e->getId()."&oid=".$o->getId()) ?>
 <? include_partial("show/showEntitlementPack", array("e"=>$e,"oe"=>NULL)) ?>
 <br>
<? endforeach ?>
<form action="subscribeService/subscribe" method="POST">
<?php echo __('Secret token for subscription of the organization'); ?>
<br>
<input type="hidden" name="oid" value="<?php echo  $o->getId() ?>">
<input type="hidden" name="from" value="<?php echo  $sf_user->getPrincipalId() ?>">
<input name="token">
<input type="submit" value="<?php echo __('Send'); ?>" />
</form>


<script>
$(document).ready(function() {
        /* Szolgáltatás névjegye */
        $('.entitlementpackcard').dialog({
                autoOpen: false,
                width: 600,
                title: '<?php echo __('Entitlement pack details'); ?>'
        });
});
</script>
