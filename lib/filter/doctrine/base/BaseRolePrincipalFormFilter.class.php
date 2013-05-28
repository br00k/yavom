<?php

/**
 * RolePrincipal filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRolePrincipalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
      'principal_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => true)),
      'expiration'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'role_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Role'), 'column' => 'id')),
      'principal_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Principal'), 'column' => 'id')),
      'expiration'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('role_principal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RolePrincipal';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'role_id'      => 'ForeignKey',
      'principal_id' => 'ForeignKey',
      'expiration'   => 'Date',
    );
  }
}
