<?php

/**
 * RoleEntitlement form base class.
 *
 * @method RoleEntitlement getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRoleEntitlementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'role_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => false)),
      'entitlement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entitlement'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'role_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Role'))),
      'entitlement_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entitlement'))),
    ));

    $this->widgetSchema->setNameFormat('role_entitlement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RoleEntitlement';
  }

}
