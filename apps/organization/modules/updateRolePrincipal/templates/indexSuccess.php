<?php
use_javascript('/sfFormExtraPlugin/js/double_list.js');

include_partial("miez",array("r"=>$r));

$defaults = array();
/*
foreach ($r->getPrincipal() as $p){
  $defaults[]=$p->getId();
}
*/
foreach ($r->getPrincipal() as $p)
{
  $defaults[]=$p->getId();
}
$form->setDefault('principal_id',$defaults);
$form->setDefault('role_id',$r->getId());
?>


<form action="<?php echo url_for('updateRolePrincipal/processForm') ?>" onsubmit="double_list_submit(this, 'double_list_select'); return true;">
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Send'); ?>" />
</form>
