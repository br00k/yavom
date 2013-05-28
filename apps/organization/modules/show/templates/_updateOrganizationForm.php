<?php
/*$form->setDefault('id',$o->getId());
$form->setDefault('name',$o->getName());
$form->setDefault('description',$o->getDescription());
$form->setDefault('default_role_id',$o->getDefaultRoleId());
*/
?>

<form action="<?php echo url_for('show/processUpdateOrgForm') ?>" method="POST" >
  <?php echo $form->renderHiddenFields() ?>
  <table>
    <tr>
      <th><?php echo $form['name']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name'] ?>
      </td>
    <tr>
    <tr>
      <th><?php echo $form['description']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['description']->renderError() ?>
        <?php echo $form['description'] ?>
      </td>
    <tr>
    <tr>
      <th><?php echo $form['default_role_id']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['default_role_id']->renderError() ?>
        <?php echo $form['default_role_id'] ?>
      </td>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
