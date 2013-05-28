<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<br>

<?php echo __('%lname%, %email% - the manager of organization <strong>%organization%</strong> has sent you a message as a member of the role %rname%, which is the following:', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%organization%"=>$o, "%rname%"=>$r->getName()))?>
<br>
<br>

<?php echo $m ?>

<br>

<hr>
<br>
<?php echo __('For further information please contact him personally.')?>
<br>
<br>
<br>
<?php echo __('Best regards,')?>
<br>
VO<br>
aai.sztaki.hu
 
