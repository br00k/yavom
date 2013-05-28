<?php

/**
 * EntitlementPackEntitlement filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEntitlementPackEntitlementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entitlement_pack_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'), 'add_empty' => true)),
      'entitlement_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entitlement'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'entitlement_pack_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EntitlementPack'), 'column' => 'id')),
      'entitlement_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entitlement'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('entitlement_pack_entitlement_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntitlementPackEntitlement';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'entitlement_pack_id' => 'ForeignKey',
      'entitlement_id'      => 'ForeignKey',
    );
  }
}
