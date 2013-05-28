
<form action="<?php echo url_for('default/processNewOrgForm') ?>" method="POST" >
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
      <th><?php echo $form['role_name']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['role_name']->renderError() ?>
        <?php echo $form['role_name'] ?>
      </td>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
