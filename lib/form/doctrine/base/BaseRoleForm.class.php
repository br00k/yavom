<?php

/**
 * Role form base class.
 *
 * @method Role getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRoleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'organization_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => false)),
      'showorder'        => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'principal_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Principal')),
      'entitlement_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'organization_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'))),
      'showorder'        => new sfValidatorInteger(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'principal_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Principal', 'required' => false)),
      'entitlement_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Role';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['principal_list']))
    {
      $this->setDefault('principal_list', $this->object->Principal->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['entitlement_list']))
    {
      $this->setDefault('entitlement_list', $this->object->Entitlement->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePrincipalList($con);
    $this->saveEntitlementList($con);

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

  public function saveEntitlementList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['entitlement_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Entitlement->getPrimaryKeys();
    $values = $this->getValue('entitlement_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Entitlement', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Entitlement', array_values($link));
    }
  }

}
