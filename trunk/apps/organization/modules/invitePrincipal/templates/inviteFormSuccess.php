<h2><?php echo __('Invite new member')?></h2>
<form action="<?php echo url_for('invitePrincipal/create') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>
  <table>
    <tr>
      <th><?php echo $form['email']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['email']->renderError() ?>
        <?php echo $form['email'] ?>
      </td>
    <tr>
    <tr>
      <th><?php echo $form['message']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['message']->renderError() ?>
        <?php echo $form['message'] ?>
      </td>
    <tr>
    <tr>
      <th><?php echo $form['role_id']->renderLabel() ?>:</th>
      <td>
        <?php echo $form['role_id']->renderError() ?>
        <?php echo $form['role_id'] ?>
      </td>
    <tr>
      <td colspan="2">
        <input type="submit" value="<?php echo __("Send"); ?>" />
      </td>
    </tr>
  </table>
</form>
