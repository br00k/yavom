<?php

/**
 * RolePrincipal form base class.
 *
 * @method RolePrincipal getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRolePrincipalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'role_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => false)),
      'principal_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => false)),
      'expiration'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'role_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Role'))),
      'principal_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'))),
      'expiration'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_principal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RolePrincipal';
  }

}
