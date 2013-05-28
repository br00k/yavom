<?php

class GetEntitlementsForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'service_id'    => new sfWidgetFormDoctrineChoice( array(
	'model' => 'Service',
        'order_by' => array('Name','asc'),
        )),
      'principal_id'    => new sfWidgetFormDoctrineChoice( array(
	'model' => 'Principal',
        'order_by' => array('Fedid','asc'),
        )),
    ));
    $this->setValidators(array(
      'service_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Service',
      )),
      'principal_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Principal',
      )),
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
    ));
  }
}

?>
