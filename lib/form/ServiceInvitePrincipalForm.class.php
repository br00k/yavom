<?php

class ServiceInvitePrincipalForm extends BaseForm
{
  public function configure()
  {

    $i18n = sfContext::getInstance()->getI18N();
    
    $this->setWidgets(array(
      's_id'    => new sfWidgetFormInputHidden( array(
        )),
      'email'    => new sfWidgetFormInputText( array(
        'label' => $i18n-> __('List of email addresses, separated by comma'),
        )),
      'message'    => new sfWidgetFormTextarea( array(
        'label' => $i18n-> __('Private message'),
        )),
    ));
    $this->setValidators(array(
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
      'email' => new sfValidatorEmailList(array(
      )),
      's_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Service',
      )),
      'message' => new sfValidatorString(array(
        'required' => false
      )),
    ));

    $this->widgetSchema->setNameFormat('invite[%s]');

  }
}

?>
