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

<?php echo __('%lname%, %email% - the manager of organization <strong>%organization%</strong> kindly asks you to join his organization, to the role %rname%', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%organization%"=>$o, "%rname%"=>$r->getName()))?>
<br>
<br>
<hr>
<?php echo __('<strong>%organization%</strong> organization description:',array("%organization%"=>$o))?>
<br>
<br>
<?php echo  $o->getDescription()?>
<br>
<br>
<?php echo __('<strong>%role%</strong> role description:',array("%role%"=>$r->getName()))?>
<br>
<br>
<?php echo  $r->getDescription()?>
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
