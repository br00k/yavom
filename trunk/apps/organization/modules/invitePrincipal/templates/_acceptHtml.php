<h1><?__('Dear Sir/Madam,')?></h1>
<br>
<?php echo __('Our system is a virtual organizations manager software, this e-mail is sent by our robot.')?>
<br>

<?php echo __('%lname%, %email% has accepted the invitation to <strong>%organization%::%rname%</strong> role.', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%organization%"=>$o, "%rname%"=>$r->getName())); ?>
<br>  
<?php echo  link_to(__("Organization details"),url_for("show/index?id=".$o->getId(),true)) ?>
<br>
<br>
<br>
<?php echo __('Best regards,'); ?>
<br>
VO<br>
aai.sztaki.hu
