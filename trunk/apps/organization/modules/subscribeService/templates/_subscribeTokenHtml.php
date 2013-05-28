<h1><?php echo __('Dear Sir/Madam,')?> </h1>
<br>
<br>

<?php echo __('%lname%, %email% - the manager of organization <strong>%organization%</strong> has subscribed his/her organization to %service%::%ep% entitlement pack using a token.', array("%lname%"=>$p->getUser()->getLastName(), "%email%"=>$p->getUser()->getEmailAddress(), "%organization%"=>$o, "%rname%"=>$r->getName(),"%service%"=>$s, "%ep%"=>$ep->getName()))?>
<br>
<br>

<?php echo __('You can review the service subscriptions at the service page:') ?>
<br>
<a href="<?php echo sfProjectConfiguration::getActive()->generateServiceUrl('default',array('sf_culture'=>'hu','module'=>'show','action'=>'index','id'=>$s->getId())); ?>"><?php echo __('Service page') ?></a>
<br>
<br>
<br>

<hr>
<br>
<?php echo __('For further information please contact him/her personally.')?>
<br>
<br>
<br>
<?php echo __('Best regards,')?>
<br>
VO<br>
aai.sztaki.hu
 
