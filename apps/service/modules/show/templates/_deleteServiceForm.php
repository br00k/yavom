<div class="dialog service_delete">
<?php echo __('You are about to permanently delete service <strong>%service%</strong>! If you delete it, the service will be removed from any connected organizations. This is the last warning!', array("%service%"=>$s->getName())) ?>

<form action="<?php echo url_for('service/delete') ?>" method="POST" >
  <input type="hidden" name="id" value="<?php echo  $s->getId() ?>">
      <p><?php echo __("If you are sure, type 'Yes, do as I say!'")?></p>
      <p>
        <input name="confirm">
      </p>
      <p>
        <input type="submit" value="<?php echo __('Send'); ?>" />
      </p>
</form>
</div>
