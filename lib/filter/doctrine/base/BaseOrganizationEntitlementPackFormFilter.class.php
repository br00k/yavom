<?php

/**
 * OrganizationEntitlementPack filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOrganizationEntitlementPackFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'entitlement_pack_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntitlementPack'), 'add_empty' => true)),
      'status'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'pending' => 'pending', 'accepted' => 'accepted'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'accept_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'organization_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'entitlement_pack_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EntitlementPack'), 'column' => 'id')),
      'status'              => new sfValidatorChoice(array('required' => false, 'choices' => array('pending' => 'pending', 'accepted' => 'accepted'))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'accept_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('organization_entitlement_pack_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrganizationEntitlementPack';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'organization_id'     => 'ForeignKey',
      'entitlement_pack_id' => 'ForeignKey',
      'status'              => 'Enum',
      'created_at'          => 'Date',
      'accept_at'           => 'Date',
    );
  }
}
