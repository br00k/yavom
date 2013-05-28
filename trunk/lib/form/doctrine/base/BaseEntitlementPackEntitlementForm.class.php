<?php

/**
 * EntitlementPackEntitlement form base class.
 *
 * @method EntitlementPackEntitlement getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEntitlementPackEntitlementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'entitlement_pack_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'), 'add_empty' => false)),
      'entitlement_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entitlement'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'entitlement_pack_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'))),
      'entitlement_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entitlement'))),
    ));

    $this->widgetSchema->setNameFormat('entitlement_pack_entitlement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntitlementPackEntitlement';
  }

}
