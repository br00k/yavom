<?php

/**
 * Organization filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOrganizationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(),
      'default_role_id' => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'principal_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Principal')),
      'service_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Service')),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'default_role_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'principal_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Principal', 'required' => false)),
      'service_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Service', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('organization_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.OrganizationPrincipal OrganizationPrincipal')
      ->andWhereIn('OrganizationPrincipal.principal_id', $values)
    ;
  }

  public function addServiceListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.OrganizationService OrganizationService')
      ->andWhereIn('OrganizationService.service_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Organization';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'description'     => 'Text',
      'default_role_id' => 'Number',
      'created_at'      => 'Date',
      'principal_list'  => 'ManyKey',
      'service_list'    => 'ManyKey',
    );
  }
}
