<?php

/**
 * Principal filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePrincipalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fedid'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'role_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
      'organization_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Organization')),
    ));

    $this->setValidators(array(
      'fedid'             => new sfValidatorPass(array('required' => false)),
      'role_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
      'organization_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Organization', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('principal_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.RolePrincipal RolePrincipal')
      ->andWhereIn('RolePrincipal.role_id', $values)
    ;
  }

  public function addOrganizationListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('OrganizationPrincipal.organization_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Principal';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'fedid'             => 'Text',
      'role_list'         => 'ManyKey',
      'organization_list' => 'ManyKey',
    );
  }
}
