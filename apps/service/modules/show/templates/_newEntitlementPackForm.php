<?php
$form->setDefault('id',$s->getId());
?>

<form action="<?php echo url_for('show/processNewServEntitlementPackForm') ?>" >
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Send'); ?>" />
</form>
