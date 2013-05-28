<?php

class InvitePrincipalForm extends BaseForm
{
  public function configure()
  {

    $i18n = sfContext::getInstance()->getI18N();
    $choices = array();
    if (isset($this->options['role_id_choices'])){
      $choices = $this->options['role_id_choices'];
    }
    $this->setWidgets(array(
      'o_id'    => new sfWidgetFormInputHidden( array(
        )),
      'email'    => new sfWidgetFormInputText( array(
        'label' => $i18n-> __('List of email addresses, separated by comma'),
        )),
      'message'    => new sfWidgetFormTextarea( array(
        'label' => $i18n-> __('Private message'),
        )),
      'role_id'    => new sfWidgetFormChoice( array(
        'label' => $i18n-> __('Role'),
        'choices' => $choices,
        )),
    ));
    $this->setValidators(array(
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
      'email' => new sfValidatorEmailList(array(
      )),
      'o_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Organization',
      )),
      'role_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Role',
      )),
      'message' => new sfValidatorString(array(
        'required' => false
      )),
    ));

    $this->widgetSchema->setNameFormat('invite[%s]');

  }
}

?>
