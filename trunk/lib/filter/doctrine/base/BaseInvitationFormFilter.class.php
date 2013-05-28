<?php

/**
 * Invitation filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInvitationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'principal_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => true)),
      'inviter_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inviter'), 'add_empty' => true)),
      'email'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'uuid'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'pending' => 'pending', 'accepted' => 'accepted'))),
      'counter'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'accept_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'last_reinvite_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'organization_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'role_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'principal_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Principal'), 'column' => 'id')),
      'inviter_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inviter'), 'column' => 'id')),
      'email'            => new sfValidatorPass(array('required' => false)),
      'uuid'             => new sfValidatorPass(array('required' => false)),
      'status'           => new sfValidatorChoice(array('required' => false, 'choices' => array('pending' => 'pending', 'accepted' => 'accepted'))),
      'counter'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'accept_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'last_reinvite_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'organization_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'role_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Role'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('invitation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invitation';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'principal_id'     => 'ForeignKey',
      'inviter_id'       => 'ForeignKey',
      'email'            => 'Text',
      'uuid'             => 'Text',
      'status'           => 'Enum',
      'counter'          => 'Number',
      'created_at'       => 'Date',
      'accept_at'        => 'Date',
      'last_reinvite_at' => 'Date',
      'organization_id'  => 'ForeignKey',
      'role_id'          => 'ForeignKey',
    );
  }
}
