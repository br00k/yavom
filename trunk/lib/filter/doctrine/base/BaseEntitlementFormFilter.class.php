<?php

/**
 * Entitlement filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEntitlementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                  => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'uri'                   => new sfWidgetFormFilterInput(),
      'service_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'role_list'             => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
      'entitlement_pack_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'EntitlementPack')),
    ));

    $this->setValidators(array(
      'name'                  => new sfValidatorPass(array('required' => false)),
      'description'           => new sfValidatorPass(array('required' => false)),
      'uri'                   => new sfValidatorPass(array('required' => false)),
      'service_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'role_list'             => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
      'entitlement_pack_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'EntitlementPack', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entitlement_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRoleListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.RoleEntitlement RoleEntitlement')
      ->andWhereIn('RoleEntitlement.role_id', $values)
    ;
  }

  public function addEntitlementPackListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.EntitlementPackEntitlement EntitlementPackEntitlement')
      ->andWhereIn('EntitlementPackEntitlement.entitlement_pack_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Entitlement';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'name'                  => 'Text',
      'description'           => 'Text',
      'uri'                   => 'Text',
      'service_id'            => 'ForeignKey',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'role_list'             => 'ManyKey',
      'entitlement_pack_list' => 'ManyKey',
    );
  }
}
