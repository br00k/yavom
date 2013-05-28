<?php

/**
 * Organization form base class.
 *
 * @method Organization getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOrganizationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormInputText(),
      'default_role_id' => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'principal_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Principal')),
      'service_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Service')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'default_role_id' => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'principal_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Principal', 'required' => false)),
      'service_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Service', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Organization', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('organization[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Organization';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['principal_list']))
    {
      $this->setDefault('principal_list', $this->object->Principal->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['service_list']))
    {
      $this->setDefault('service_list', $this->object->Service->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePrincipalList($con);
    $this->saveServiceList($con);

    parent::doSave($con);
  }

  public function savePrincipalList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['principal_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Principal->getPrimaryKeys();
    $values = $this->getValue('principal_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Principal', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Principal', array_values($link));
    }
  }

  public function saveServiceList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['service_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Service->getPrimaryKeys();
    $values = $this->getValue('service_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Service', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Service', array_values($link));
    }
  }

}
