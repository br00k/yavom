<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<?php echo __('Our system is a virtual organizations manager software, this e-mail is sent by our robot.')?>
<br>
<br>
<br>
<?php echo __("A manager of organization <strong>%organization%</strong> has modified the members of role <strong>%role%</strong>.", array("%organization%"=>$o, "%role%"=>$r->getName())); ?>
<br>
<br>
<a href="<?php echo url_for('show/index?id='.$o->getId(),true)?>"><?php echo __('Organization page') ?></a>
<br>
<br>
<?php echo __('For further information please contact the organization managers.')?>
<br>
<br>
<br>
<br>
<?php echo __('Best regards,'); ?>
<br>
VO<br>
aai.sztaki.hu
