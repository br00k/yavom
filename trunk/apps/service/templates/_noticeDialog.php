<?if ($sf_user->hasFlash('notice')):?>
  <div id="notice">
    <?php echo  $sf_user->getFlash('notice') ?>
  </div>
  <script>
  $(document).ready(function() {
    $('#notice').dialog({ autoOpen: true });
  });
  </script>
<?endif?>
<?php if ($sf_user->hasFlash('error')): ?>
  <div id="flash_error">
    <?php echo $sf_user->getFlash('error') ?>
  </div>
  <script>
  $(document).ready(function() {
    $('#flash_error').dialog({ autoOpen: true });
  });
  </script>
<?php endif ?>
