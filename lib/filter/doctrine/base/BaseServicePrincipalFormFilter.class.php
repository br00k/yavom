<?php

/**
 * ServicePrincipal filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseServicePrincipalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'service_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'principal_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'service_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'principal_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Principal'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('service_principal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ServicePrincipal';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'service_id'   => 'ForeignKey',
      'principal_id' => 'ForeignKey',
    );
  }
}
