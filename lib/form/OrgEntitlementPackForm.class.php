<?php

class OrgEntitlementPackForm extends BaseForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText( array("label"=>("Name")),
      'description'   => new sfWidgetFormTextarea( array("label"=>$i18n->__("Descripton")),
      'id'   => new sfWidgetFormInputHidden( array()),
    ));
    $this->setValidators(array(
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
    ));
  }
}

?>
