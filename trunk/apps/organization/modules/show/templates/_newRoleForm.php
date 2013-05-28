<?php
$form->setDefault('id',$o->getId());
?>

<form action="<?php echo url_for('show/processNewOrgRoleForm') ?>" >
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Send'); ?>" />
</form>
