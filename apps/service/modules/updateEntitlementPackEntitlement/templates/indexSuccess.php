<?php
use_javascript('/sfFormExtraPlugin/js/double_list.js');

include_partial("miez",array("r"=>$r));
?>


<form action="<?php echo url_for('updateEntitlementPackEntitlement/processForm') ?>" onsubmit="double_list_submit(this, 'double_list_select'); return true;">
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Send'); ?>" />
</form>
