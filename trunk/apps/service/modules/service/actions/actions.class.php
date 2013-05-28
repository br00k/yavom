<?php

require_once dirname(__FILE__).'/../lib/serviceGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/serviceGeneratorHelper.class.php';

/**
 * service actions.
 *
 * @package    sf_sandbox
 * @subpackage service
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class serviceActions extends autoServiceActions
{
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $form->getObject()->setPrincipalId($this->getUser()->getPrincipalId());
    $form->getObject()->setType('pending');
    $s = $form->getObject();
    if (! $form->isNew())
    {
      $this->checkIsMy($form->getObject());
    }
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? $i18n->__('The service has been created.') : $i18n->__('The service has been updated.');

      try {
        $service = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }
      
      if ($form->isNew()){         
      $sp = new ServicePrincipal();
      $sp->setServiceId($form->getObject()->getId());
      $sp->setPrincipalId($this->getUser()->getPrincipalId());
      $sp->save();
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $service)));

      $this->getUser()->setFlash('notice', $notice);

      $this->redirect("show/index?id=".$form->getObject()->getId());
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $i18n = sfContext::getInstance()->getI18N();
    $s = Doctrine::getTable('Service')->find($request->getParameter('id'));

    $this->checkIsMy($s);

    if ($request->getParameter("confirm") != $i18n->__("Yes, do as I say!"))
    {
      $this->getUser()->setFlash('notice', $i18n->__('The service has not been deleted.'));
      $this->redirect('show/index?id='.$s->getId());
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $s)));

    if ($s->delete())
    {
      $this->getUser()->setFlash('notice', $i18n->__('The service has been deleted successfully.'));
    }
    $this->redirect('default/index');
  }
  
  public function executeValidateForm(sfWebRequest $request)
  {
        $i18n = sfContext::getInstance()->getI18N();
  	$s_id = $request->getParameter('id');
  	$s = Doctrine::getTable('Service')->find($s_id);
  	$this->s = $s;
  	$s_entityId = $s->getEntityId(); 
  	$metadata = SimpleSAML_Metadata_MetaDataStorageHandler::getMetadataHandler();
  	try
  	{
  	  $entity = $metadata->getMetaData($s_entityId,'saml20-sp-remote');
  	} catch (Exception $e) {
  	  $this->getUser()->setFlash('error',$i18n->__('An error occured: %message%',array("%message%"=>$e->getMessage())));
  	  $this->redirect("show/index?id=".$s_id);
  	}
  	
  	$this->form = new SendTokenToSPOwnerForm(array('s_id'=>$request->getParameter('id'), 'entity'=>$entity));  	
  }
  
  public function executeProcessValidateForm(sfWebRequest $request){
  	$i18n = sfContext::getInstance()->getI18N();
  	$formarray = $request->getParameter('token');
  	$s_id = $formarray['s_id'];  	
  	$s = Doctrine::getTable('Service')->find($s_id);
  	$s_entityId = $s->getEntityId(); 
  	$metadata = SimpleSAML_Metadata_MetaDataStorageHandler::getMetadataHandler();
  	$entity = $metadata->getMetaData($s_entityId,'saml20-sp-remote');
  	$form = new SendTokenToSPOwnerForm(array('s_id'=>$s_id, 'entity'=>$entity));  	
  	$form->bind($request->getParameter($form->getName()));
	
  	if (! $form->isValid()) {
  		$this->getUser()->setFlash('notice',$i18n->__('Could not send the invitation, please check the e-mail address and try again!'));
  		$this->redirect("show/index?id=".$s_id);
  	}
  	
  	$emails = $form->getValue('email');
  	$s_id  = $form->getValue('s_id');  	
  	$m = $form->getValue('message');
  	$s = Doctrine::getTable('Service')->find($s_id);
  	
  	$this->checkIsMy($s);
  	
  	/* Set the token to Service */
  	$token = uniqid();
  	$s->setToken($token);
  	$s->save();
  	  	
  	/* Send validating emails */
  	$params= array("s"=>$s, "p"=>$this->getUser()->getPrincipal(),"m"=>$m);
  	$email_params=array(
  			"to" => $emails,
  			"subject" => $i18n->__('Validating code to %service% service.',array("%service%"=>$s)),
  			"bodyhtml" => $this->getPartial('service/validatingHtml',$params),
  	);
  	$this->sendEmail($email_params);
  	
  	/* Set the notice to user */
  	$this->getUser()->setFlash('notice',$i18n->__('The validation code is sent, please check your e-mails!'));
  	$this->redirect("show/index?id=".$s_id);  	
  }
  
  public function executeValidate(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $s_id = $request->getParameter('id'); 
    $token = $request->getParameter('token'); 
    $s = Doctrine::getTable('Service')->find($s_id);
    if (!$s){
      $this->case = 'invalid_service_id';
      $this->getUser()->setFlash('error',$i18n->__('The service id is invalid!'));
      $this->redirect("default");      
    }
    $this->checkIsMy($s);
    if ($s->getType() == 'valid'){
      $this->case = 'already_valid';      
      $this->getUser()->setFlash('notice',$i18n->__('The service ownership is already validated.'));
      $this->redirect("show/index?id=".$s_id);
    }

    if ($s->getToken() == $token){
      $s->setType('valid');
      $s->save();
      $this->case = 'validated';
    }
    else {
      $this->case = 'invalid_token';
    }
    /* Set the notice to user */
    $this->getUser()->setFlash('notice',$i18n->__('The service ownership is validated now.'));
    /* Send mail about success to the service managers */
    /*$to = 
    $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $to, $i18n->__(ProjectConfiguration::$mail_tag.'Service %s% has been validated',array("%s%"=>$s)));
       $html  = $this->getPartial('service/validatedHtml', array("s"=>$s));
       $mail->setBody($html, 'text/html');

       $this->getMailer()->send($mail);
    */
    $email_params=array(
  			"to" => $s->getManagersEmailArray(),
  			"subject" => $i18n->__(ProjectConfiguration::$mail_tag.'Service %s% has been validated',array("%s%"=>$s)),
  			"bodyhtml" => $this->getPartial('service/validatedHtml', array("s"=>$s)),
  	);
  	$this->sendEmail($email_params);
    $this->redirect("show/index?id=".$s_id);
  }


  private function checkIsMy($s)
  {
    $i18n = sfContext::getInstance()->getI18N();
    if (! $s->isMy())
    {
      $m=$i18n->__("Insufficent rights");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
  }
  
  public function sendEmail($params)
  {
  	$message = $this->getMailer()->compose();
  	$message->setSubject(ProjectConfiguration::$mail_tag.$params['subject']);
  	$message->setTo($params['to']);
  	$message->setFrom(ProjectConfiguration::$mail_from);
  	$message->setBody($params['bodyhtml'], 'text/html');
  	$this->getMailer()->send($message);
  }
  
}
