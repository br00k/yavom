<?php
use_javascript('/sfFormExtraPlugin/js/double_list.js');

include_partial("miez",array("o"=>$o));

$defaults = array();
foreach ($o->getPrincipal() as $p){
  $defaults[]=$p->getId();
}
$form->setDefault('principal_id',$defaults);
$form->setDefault('organization_id',$o->getId());
?>


<form action="<?php echo url_for('updateOrganizationPrincipal/processForm') ?>" onsubmit="double_list_submit(this, 'double_list_select'); return true;">
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Send'); ?>" />
</form>
