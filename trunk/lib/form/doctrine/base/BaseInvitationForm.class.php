<?php

/**
 * Invitation form base class.
 *
 * @method Invitation getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInvitationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'principal_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => true)),
      'inviter_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inviter'), 'add_empty' => false)),
      'email'            => new sfWidgetFormInputText(),
      'uuid'             => new sfWidgetFormInputText(),
      'status'           => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'accepted' => 'accepted'))),
      'counter'          => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'accept_at'        => new sfWidgetFormDateTime(),
      'last_reinvite_at' => new sfWidgetFormDateTime(),
      'organization_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => false)),
      'role_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'principal_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'required' => false)),
      'inviter_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inviter'))),
      'email'            => new sfValidatorString(array('max_length' => 255)),
      'uuid'             => new sfValidatorString(array('max_length' => 255)),
      'status'           => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'accepted'))),
      'counter'          => new sfValidatorInteger(),
      'created_at'       => new sfValidatorDateTime(),
      'accept_at'        => new sfValidatorDateTime(array('required' => false)),
      'last_reinvite_at' => new sfValidatorDateTime(array('required' => false)),
      'organization_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'))),
      'role_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invitation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invitation';
  }

}
