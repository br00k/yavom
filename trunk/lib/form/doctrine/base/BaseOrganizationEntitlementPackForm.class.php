<?php

/**
 * OrganizationEntitlementPack form base class.
 *
 * @method OrganizationEntitlementPack getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOrganizationEntitlementPackForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => false)),
      'entitlement_pack_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'), 'add_empty' => false)),
      'status'              => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'accepted' => 'accepted'))),
      'created_at'          => new sfWidgetFormDateTime(),
      'accept_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'organization_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'))),
      'entitlement_pack_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'))),
      'status'              => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'accepted'))),
      'created_at'          => new sfValidatorDateTime(),
      'accept_at'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('organization_entitlement_pack[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrganizationEntitlementPack';
  }

}
