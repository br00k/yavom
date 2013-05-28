<div class="dialog organization_delete" id="<?php echo $o->getId()?>">
<?php echo __('You are about to permanently delete organization <strong>%organization%</strong>! If you delete it, any connected roles will be deleted, entitlement links will be lost. This is the last warning!', array("%organization%"=>$o->getName())) ?>

<form action="<?php echo url_for('default/processDeleteOrgForm') ?>" method="POST" >
  <input type="hidden" name="id" value="<?php echo  $o->getId() ?>">
  <table>
    <tr>
      <td>
        <p><?php echo __("If you are sure, type 'Yes, do as I say!'")?><p>
        <input name="confirm">
      </td>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
</div>