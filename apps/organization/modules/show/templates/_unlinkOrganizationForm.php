<div class="dialog organization_unlink" id="<?php echo $epid?>">
<?php echo __('You are about to unlink entitlement package <strong>%entitlementpack%</strong> from organization <strong>%organization%</strong>! If you do so the entitlements in the package will become unavailable for the organization. This is the last warning!',array("%entitlementpack%"=>$e->getName(), "%organization%"=>$o->getName())) ?>

<form action="<?php echo url_for('show/unlinkOrganization') ?>" method="POST" >
  <input type="hidden" name="oid" value="<?php echo  $o->getId() ?>">
  <input type="hidden" name="eid" value="<?php echo  $e->getId() ?>">
      <p>H<?php echo __("If you are sure, type 'Yes, do as I say!'")?></p>
      <p>
        <input name="confirm">
      </p>
      <p>
        <input type="submit" />
      </p>
</form>
</div>
