<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<?php echo __('Our system is a virtual organizations manager software, this e-mail is sent by our robot.')?>
<br>

<?php echo __("%lname%, %email% - the manager of service <strong>%service%</strong> has sent you the sercet token of his/her service's entitlement pack <strong>%ep%</strong>. <br>Using this token, you can subscribe your organization to the entitlements of the said package.", array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%service%"=>$s, "%ep%"=>$ep->getName())); ?>
<br>
<?php echo __('For further information please contact him/her personally.')?>
<br>
<?php echo __('The token:'); ?>
<br>
<h2>
<?php echo  $ep->getToken()?>
</h2>
<br>
<?php echo __("You may redeem your token at your organization's maganement page, under 'Subscribed service entitlements'.");?>
<br>
<?php echo __('%lname%, %email% has also sent you a private message, which is the following: ',array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress()))?>
<br>
<?php echo  $m ?>
<br>
<br>
<br>
<br>
<?php echo __('Best regards,'); ?>
<br>
VO<br>
aai.sztaki.hu
