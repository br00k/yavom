<div id="hint">
<? $problema=FALSE; ?>
<?php if (count($o->getRelatedPrincipal()) < 2): ?>
<p>
<?php echo __('The organization has only one member. Invite some more!'); ?> 
</p>
<? $problema=TRUE; endif ?>

<?php if (count($o->getRole()) < 1): ?>
<p>
<?php echo __('The organization has no roles. Define at least one!'); ?> 
</p>
<? $problema=TRUE; endif ?>

<?php if (count($o->getService()) < 1): ?>
<p>
<?php echo __('There are no connected services. Subsrcibe to one!'); ?>
</p>
<? $problema=TRUE; endif ?>

<?php foreach ($o->getRole() as $r): ?>
  <? if(count($r->getEntitlement()) < 1):?> 
    <p>
    <?php echo __("The role '%rname%' has no entitlements. Connect some!",array("%rname%"=>$r)); ?>
    </p>
  <? $problema=TRUE; endif ?>
  <? if(count($r->getPrincipal()) < 1):?> 
    <p>
    <?php echo __("The role '%rname%' has no members. Connect some!",array("%rname%"=>$r)); ?>
    </p>
  <? $problema=TRUE; endif ?>
<? endforeach ?>

<?php if (! $problema): ?>
<p>
<?php echo __("There are no hints, This organization probably operates well. Congrats!"); ?>
</p>
<? endif ?>
</div>
