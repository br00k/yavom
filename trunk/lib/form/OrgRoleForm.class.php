<?php

class OrgRoleForm extends BaseForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText( array("label"=>$i18n->__("Role name"))),
      'description'   => new sfWidgetFormTextarea( array("label"=>$i18n->__("Role description"))),
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
