<?php

class SendTokenForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      's_id'    => new sfWidgetFormInputHidden( array(
        )),
      'ep_id'    => new sfWidgetFormInputHidden( array(
        )),
      'email'    => new sfWidgetFormInputText( array(
        'label' => 'Email cím',
        )),
      'message'    => new sfWidgetFormTextarea( array(
        'label' => 'Személyes üzenet',
        )),
    ));
    $this->setValidators(array(
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
      'email' => new sfValidatorEmail(array(
      )),
      's_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Service',
      )),
      'ep_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'EntitlementPack',
      )),
    ));
  }
}

?>
