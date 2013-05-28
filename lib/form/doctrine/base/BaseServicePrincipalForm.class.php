<?php

/**
 * ServicePrincipal form base class.
 *
 * @method ServicePrincipal getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseServicePrincipalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'service_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => false)),
      'principal_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'service_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'))),
      'principal_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'))),
    ));

    $this->widgetSchema->setNameFormat('service_principal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ServicePrincipal';
  }

}
