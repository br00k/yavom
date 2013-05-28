<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<br>

<?php echo __('A manager of organization <strong>%organization%</strong> has unsubscribed his/her organization from %service%::%ep%', array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$ep))?>
<br>
<br>

<?php echo __('You can review the service subscriptions at the service page:') ?>
<br>
<a href="<?php echo url_for('service/show?id='.$s->getId(),true) ?>"><?php echo __('Service page') ?></a>

<br>

<hr>
<br>
<?php echo __('For further information please contact the organization managers.')?>
<br>
<br>
<br>
<?php echo __('Best regards,')?>
<br>
VO<br>
aai.sztaki.hu
 
