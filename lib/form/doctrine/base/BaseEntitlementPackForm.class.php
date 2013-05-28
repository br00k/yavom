<?php

/**
 * EntitlementPack form base class.
 *
 * @method EntitlementPack getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEntitlementPackForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'service_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => false)),
      'showorder'        => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'type'             => new sfWidgetFormChoice(array('choices' => array('test' => 'test', 'hidden' => 'hidden', 'browseable' => 'browseable'))),
      'token'            => new sfWidgetFormInputText(),
      'entitlement_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'service_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'))),
      'showorder'        => new sfValidatorInteger(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'type'             => new sfValidatorChoice(array('choices' => array(0 => 'test', 1 => 'hidden', 2 => 'browseable'))),
      'token'            => new sfValidatorPass(array('required' => false)),
      'entitlement_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Entitlement', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entitlement_pack[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntitlementPack';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['entitlement_list']))
    {
      $this->setDefault('entitlement_list', $this->object->Entitlement->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveEntitlementList($con);

    parent::doSave($con);
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
