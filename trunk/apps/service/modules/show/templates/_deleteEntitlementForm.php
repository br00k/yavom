<div class="dialog entitlement_delete" id="<?php echo $e->getId()?>">
<?php echo __('You are about to permanently delete entitlement <strong>%entitlement%</strong>! If you delete it, the entitlement will be removed from any connected organizations. This is the last warning!', array("%entitlement%"=>$e->getName())) ?>

<form action="<?php echo url_for('entitlement/deletea') ?>" method="POST" >
  <input type="hidden" name="id" value="<?php echo  $e->getId() ?>">
      <p><?php echo __("If you are sure, type 'Yes, do as I say!'")?></p>
      <p>
        <input name="confirm">
      </p>
      <p>
        <input type="submit" value="<?php echo __('Send'); ?>" />
      </p>
</form>
</div>
