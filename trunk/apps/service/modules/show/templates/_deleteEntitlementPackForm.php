<div class="dialog entitlement_pack_delete" id="<?php echo $r->getId()?>">
<?php echo __('You are about to permanently delete entitlement pack <strong>%entitlementpack%</strong>! If you delete it, the entitlements in the package will no longer be available to any connected organizations. This is the last warning!', array("%entitlementpack%"=>$r->getName())) ?>

<form action="<?php echo url_for('entitlement_pack/deletea') ?>" method="POST" >
  <input type="hidden" name="id" value="<?php echo  $r->getId() ?>">
      <p><?php echo __("If you are sure, type 'Yes, do as I say!'")?></p>
      <p>
        <input name="confirm">
      </p>
      <p>
        <input type="submit" value="<?php echo __('Send'); ?>" />
      </p>
</form>
</div>
