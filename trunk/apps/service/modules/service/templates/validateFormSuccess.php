<h2><?php echo __('Sending validator token')?></h2>
<p>
<?php echo $s->getName();?>
</p>
<form action="<?php echo url_for('service/processValidateForm') ?>" method="POST">
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
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>