<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<?php echo __('Our system is a virtual organizations manager software, this e-mail is sent by our robot.') ?>
<br>
<? if ($reinvite):?>
<br>
<?php echo __('This is a reminder for you have a pending invitation.')?>
<br>
<br>
<?endif?>

<?php echo __('%lname%, %email% - the manager of service <strong>%service%</strong> kindly asks you to join his service', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%service%"=>$s))?>
<br>
<br>
<hr>
<?php echo __('<strong>%service%</strong> description:',array("%service%"=>$s))?>
<br>
<br>
<?php echo  $s->getDescription()?>
<br>
<br>
<br>
<br>

<hr>
<br>
<?php echo __('For further information please contact him/her personally.')?>
<br>
<br>
<?php echo __('You can accept the invitation - after authentication - by clicking ')?>
<?php echo  link_to(__("here."),url_for("invitePrincipal/resolve?uuid=".$i->getUuid(),true)) ?>
<br>
<? if (!$reinvite):?>
<? if ($m!=""): ?>
<br>
<?php echo __('%lname%, %email% has also sent you a private message, which is the following: ',array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress()))?>
<br>
<?php echo  $m ?>
<br>
<?endif?>
<?endif?>
<br>
<br>
<br>
<?php echo __('Best regards,')?>
<br>
VO<br>
aai.sztaki.hu
