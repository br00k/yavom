<div class="dialog organization_unlink" id="<?php echo $epid?>">
A(z) <strong><?php echo  $e->getName() ?></strong> nevű jogosultságcsomag visszavonására készül a <strong><?php echo  $o->getName() ?></strong> nevű szervezettől!!! Ha visszavonja, a szervezet számára elérhetetlenné válnak a kapcsolt jogosultságok! Nagyon fontolja meg, hogy mire kattint, ez az utolsó figyelmeztetés!

<form action="<?php echo url_for('show/unlinkOrganization') ?>" method="POST" >
  <input type="hidden" name="oid" value="<?php echo  $o->getId() ?>">
  <input type="hidden" name="eid" value="<?php echo  $e->getId() ?>">
      <p>Ha biztos a dolgában, gépelje be, hogy "Igen, tedd, amit mondok!" (idézőjelek nélkül, pontosan.)</p>
      <p>
        <input name="confirm">
      </p>
      <p>
        <input type="submit" value="<?php echo __('Send'); ?>" />
      </p>
</form>
</div>
