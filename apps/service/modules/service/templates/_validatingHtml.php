<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<?php echo __('Our system is a virtual organizations manager software, this e-mail is sent by our robot.') ?>
<br>

<?php echo __('%lname%, %email% - the manager of service <strong>%service%</strong> kindly asks you to validate the service ownership', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%service%"=>$s))?>
<br>
<br>

<hr>
<br>
<?php echo __('For further information please contact him/her personally.')?>
<br>
<br>
<?php echo __('You can do the ownership validation - after authentication - by clicking ')?>
<?php echo  link_to(__("here."),url_for("service/validate?id=".$s->getId()."&token=".$s->getToken(),true)) ?>
<br>
<? if ($m!=""): ?>
<br>
<?php echo __('%lname%, %email% has also sent you a private message, which is the following: ',array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress()))?>
<br>
<?php echo  $m ?>
<br>

<?endif?>
<br>
<br>
<br>
<?php echo __('Best regards,')?>
<br>
VO<br>
aai.sztaki.hu
