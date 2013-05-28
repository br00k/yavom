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
