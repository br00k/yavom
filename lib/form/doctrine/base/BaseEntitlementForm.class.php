<?php

/**
 * Entitlement form base class.
 *
 * @method Entitlement getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEntitlementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInputText(),
      'description'           => new sfWidgetFormInputText(),
      'uri'                   => new sfWidgetFormInputText(),
      'service_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'role_list'             => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
      'entitlement_pack_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'EntitlementPack')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'           => new sfValidatorPass(array('required' => false)),
      'uri'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'service_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'role_list'             => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
      'entitlement_pack_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'EntitlementPack', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entitlement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entitlement';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['role_list']))
    {
      $this->setDefault('role_list', $this->object->Role->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['entitlement_pack_list']))
    {
      $this->setDefault('entitlement_pack_list', $this->object->EntitlementPack->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveRoleList($con);
    $this->saveEntitlementPackList($con);

    parent::doSave($con);
  }

  public function saveRoleList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['role_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Role->getPrimaryKeys();
    $values = $this->getValue('role_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Role', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Role', array_values($link));
    }
  }

  public function saveEntitlementPackList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['entitlement_pack_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->EntitlementPack->getPrimaryKeys();
    $values = $this->getValue('entitlement_pack_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('EntitlementPack', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('EntitlementPack', array_values($link));
    }
  }

}
