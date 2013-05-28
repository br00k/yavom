<?php

class SendTokenToSPOwnerForm extends BaseForm
{
  public function configure()
  {  	
  	$i18n = sfContext::getInstance()->getI18N();
  	
  	$s_id = $this->getDefault('s_id');
  	$s = Doctrine::getTable('Service')->find($s_id);
  	
  	$entity = $this->getDefault('entity');
  	  	  	  	
  	foreach($entity['contacts'] as $c){
  		$contacts[$c['emailAddress']] = $c['contactType'].' '.$c['emailAddress'];
  	}   	
  	
    $this->setWidgets(array(
      's_id'    => new sfWidgetFormInputHidden( array(
        )),
      'email'    => new sfWidgetFormChoice( array(
        'label' => $i18n->__('Email address'),
      	'choices' => $contacts,
      	'expanded' => TRUE,
      	'multiple' => TRUE,
        )),
      'message'    => new sfWidgetFormTextarea( array(
        'label' => $i18n->__('Personal message'),
        )),
    ));
    $this->setValidators(array(
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
      'email' => new sfValidatorChoice(array(
      		'choices'=> array_keys($contacts),
      		'multiple' => TRUE,
      		'min' => 1,
      )),
      's_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Service',
      )),
      'message' => new sfValidatorPass(array(
       )),
    ));
    
    $this->widgetSchema->setNameFormat('token[%s]');
  }
}

?>
