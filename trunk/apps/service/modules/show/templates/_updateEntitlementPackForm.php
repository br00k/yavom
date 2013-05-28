<?php
$form->setDefault('id',$r->getId());
$form->setDefault('name',$r->getName());
$form->setDefault('description',$r->getDescription());
?>

<form action="<?php echo url_for('show/processUpdateServEntitlementPackForm') ?>" >
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Send'); ?>" />
</form>
