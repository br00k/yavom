<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<br>

<?php echo __('A manager of organization <strong>%organization%</strong> has subscribed to the %service%::%ep% entitlement package', array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$ep->getName()))?>
<br>
<br>

<?php echo __('You can review the organization subscriptions at the organizations page:') ?>
<br>
<a href="<?php echo url_for('show/index?id='.$o->getId(),true)?>"><?php echo __('Organization page') ?></a>

<br>

<br>
<br>
<?php echo __('Best regards,')?>
<br>
VO<br>
aai.sztaki.hu