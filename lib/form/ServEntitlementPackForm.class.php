<?php

class ServEntitlementPackForm extends EntitlementPackForm
{
  public function configure()
  {
    $this->widgetSchema['service_id'] = new sfWidgetFormInputHidden();
    /*
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText( array("label"=>"Csoport neve")),
      'description'   => new sfWidgetFormTextarea( array("label"=>"Csoport leírása, céljai")),
      'id'   => new sfWidgetFormInputHidden( array()),
    ));
    $this->setValidators(array(
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
    ));*/
    
    parent::configure();
  }
}

?>
