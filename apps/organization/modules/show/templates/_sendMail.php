<div class="dialog send_mail">

<form action="<?php echo url_for('show/sendMail') ?>" method="POST" >
  <?php echo $form->renderHiddenFields() ?>
  <table>
    <tr>
      <td><?php echo __('Please select the roles to send the message below to.'); ?></td>
    </tr>
    <tr>
      <td>
        <div style="padding-left: 15px">
        <?php echo $form['ids']->renderError() ?>
        <?php echo $form['ids'] ?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <?php echo $form['message']->renderError() ?>
        <?php echo $form['message'] ?>
      </td>
    </tr>
    <tr>
      <td>
        <input type="submit" value="<?php echo __("Send"); ?>">
      </td>
    </tr>
  </table>
</form>
</div>