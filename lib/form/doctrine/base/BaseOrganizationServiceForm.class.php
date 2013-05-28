<?php

/**
 * OrganizationService form base class.
 *
 * @method OrganizationService getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOrganizationServiceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'organization_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => false)),
      'service_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => false)),
      'status'          => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'accepted' => 'accepted'))),
      'created_at'      => new sfWidgetFormDateTime(),
      'accept_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'organization_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'))),
      'service_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'))),
      'status'          => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'accepted'))),
      'created_at'      => new sfValidatorDateTime(),
      'accept_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('organization_service[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrganizationService';
  }

}
