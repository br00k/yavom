<?php

/**
 * Service filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseServiceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'              => new sfWidgetFormFilterInput(),
      'entityId'          => new sfWidgetFormFilterInput(),
      'url'               => new sfWidgetFormFilterInput(),
      'description'       => new sfWidgetFormFilterInput(),
      'principal_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => true)),
      'type'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'test' => 'test', 'hidden' => 'hidden', 'browseable' => 'browseable'))),
      'token'             => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'organization_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Organization')),
    ));

    $this->setValidators(array(
      'name'              => new sfValidatorPass(array('required' => false)),
      'entityId'          => new sfValidatorPass(array('required' => false)),
      'url'               => new sfValidatorPass(array('required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'principal_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Principal'), 'column' => 'id')),
      'type'              => new sfValidatorChoice(array('required' => false, 'choices' => array('test' => 'test', 'hidden' => 'hidden', 'browseable' => 'browseable'))),
      'token'             => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'organization_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Organization', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('service_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.OrganizationService OrganizationService')
      ->andWhereIn('OrganizationService.organization_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Service';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'name'              => 'Text',
      'entityId'          => 'Text',
      'url'               => 'Text',
      'description'       => 'Text',
      'principal_id'      => 'ForeignKey',
      'type'              => 'Enum',
      'token'             => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'organization_list' => 'ManyKey',
    );
  }
}
