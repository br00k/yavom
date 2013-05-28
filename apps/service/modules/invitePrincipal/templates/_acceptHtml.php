<h1><?__('Dear Sir/Madam,')?></h1>
<br>
<?php echo __('Our system is a virtual organizations manager software, this e-mail is sent by our robot.')?>
<br>

<?php echo __('%lname%, %email% has accepted the invitation to <strong>%service%</strong> service.', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%service%"=>$s)); ?>
<br>  
<?php echo  link_to(__("Service details"),url_for("show/index?id=".$s->getId(),true)) ?>
<br>
<br>
<br>
<?php echo __('Best regards,'); ?>
<br>
VO<br>
aai.sztaki.hu
