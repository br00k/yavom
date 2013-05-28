<div class="dialog send_token" id="<?php echo $ep->getId() ?>">
    <?php echo __('Sending the secret token of the entitlement pack to given e-mail address.')?>

<form action="<?php echo url_for('show/sendToken') ?>" method="POST">
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
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
</div>
