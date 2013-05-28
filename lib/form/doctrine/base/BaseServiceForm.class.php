<?php

/**
 * Service form base class.
 *
 * @method Service getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseServiceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'name'              => new sfWidgetFormInputText(),
      'entityId'          => new sfWidgetFormInputText(),
      'url'               => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormInputText(),
      'principal_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'), 'add_empty' => false)),
      'type'              => new sfWidgetFormChoice(array('choices' => array('test' => 'test', 'hidden' => 'hidden', 'browseable' => 'browseable'))),
      'token'             => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'organization_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Organization')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'entityId'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'url'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'principal_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Principal'))),
      'type'              => new sfValidatorChoice(array('choices' => array(0 => 'test', 1 => 'hidden', 2 => 'browseable'))),
      'token'             => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'organization_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Organization', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Service', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('service[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Service';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['organization_list']))
    {
      $this->setDefault('organization_list', $this->object->Organization->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveOrganizationList($con);

    parent::doSave($con);
  }

  public function saveOrganizationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['organization_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Organization->getPrimaryKeys();
    $values = $this->getValue('organization_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Organization', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Organization', array_values($link));
    }
  }

}
