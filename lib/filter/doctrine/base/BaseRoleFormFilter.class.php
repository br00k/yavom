<?php

/**
 * Role filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRoleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'organization_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'showorder'        => new sfWidgetFormFilterInput(),
      'description'      => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'principal_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Principal')),
      'entitlement_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement')),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'organization_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'showorder'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'      => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'principal_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Principal', 'required' => false)),
      'entitlement_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addPrincipalListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.RolePrincipal RolePrincipal')
      ->andWhereIn('RolePrincipal.principal_id', $values)
    ;
  }

  public function addEntitlementListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('RoleEntitlement.entitlement_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Role';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'organization_id'  => 'ForeignKey',
      'showorder'        => 'Number',
      'description'      => 'Text',
      'created_at'       => 'Date',
      'principal_list'   => 'ManyKey',
      'entitlement_list' => 'ManyKey',
    );
  }
}
