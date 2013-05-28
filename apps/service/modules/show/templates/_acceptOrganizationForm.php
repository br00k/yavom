<div class="dialog organization_accept" id="<?php echo $epid ?>">
<?php echo __("The <strong>%org%</strong> organization wishes to use your service. You must decide wether to let them, or deny their request. If you don't trust the organization, please select 'Deny request'.",array("%org%"=>$o->getName()))?>

<form action="<?php echo url_for('show/acceptOrganization') ?>" method="POST" >
  <input type="hidden" name="oid" value="<?php echo  $o->getId() ?>">
  <input type="hidden" name="eid" value="<?php echo  $e->getId() ?>">
      <p>
        <input name="accept" type="submit" value="<?php echo __('Grant access')?>">
      </p>
      <p>
        <input name="deny" type="submit" value="<?php echo __('Deny request')?>">
      </p>
</form>
</div>
