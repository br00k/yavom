<?php

/**
 * RoleEntitlementPack filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRoleEntitlementPackFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
      'entitlement_pack_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'role_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Role'), 'column' => 'id')),
      'entitlement_pack_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EntitlementPack'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('role_entitlement_pack_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RoleEntitlementPack';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'role_id'             => 'ForeignKey',
      'entitlement_pack_id' => 'ForeignKey',
    );
  }
}
