<h1><?php echo __('Entitlements grouped by organizations'); ?></h1>
<? //print_r($jogok); ?>
<? foreach ($os as $o): ?>

  <? // if(array_key_exists($o->getId(),$jogok)):?>
  <?  if(isset($jogok[$o->getId()])):?>
  <h2><?php echo  $o->getName() ?></h2>
  <? foreach ( $jogok[$o->getId()] as $e_id => $e ):?>
    <?php echo  include_partial("show/showEntitlement",array("e"=>$e)) ?>
  <? endforeach ?>
  <? endif ?>
<? endforeach ?>
<script>
$(document).ready(function() {
        /* Jogosultság névjegye */
        $('.entitlementcard').dialog({
                autoOpen: false,
                width: 500,
                title: '<?php echo __("Entitlement details"); ?>'
        });
});

</script>
