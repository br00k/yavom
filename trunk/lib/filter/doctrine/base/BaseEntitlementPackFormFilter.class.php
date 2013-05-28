<?php

/**
 * EntitlementPack filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEntitlementPackFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'service_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'showorder'        => new sfWidgetFormFilterInput(),
      'description'      => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'type'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'test' => 'test', 'hidden' => 'hidden', 'browseable' => 'browseable'))),
      'token'            => new sfWidgetFormFilterInput(),
      'entitlement_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement')),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'service_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'showorder'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'      => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'type'             => new sfValidatorChoice(array('required' => false, 'choices' => array('test' => 'test', 'hidden' => 'hidden', 'browseable' => 'browseable'))),
      'token'            => new sfValidatorPass(array('required' => false)),
      'entitlement_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entitlement_pack_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.EntitlementPackEntitlement EntitlementPackEntitlement')
      ->andWhereIn('EntitlementPackEntitlement.entitlement_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'EntitlementPack';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'service_id'       => 'ForeignKey',
      'showorder'        => 'Number',
      'description'      => 'Text',
      'created_at'       => 'Date',
      'type'             => 'Enum',
      'token'            => 'Text',
      'entitlement_list' => 'ManyKey',
    );
  }
}
