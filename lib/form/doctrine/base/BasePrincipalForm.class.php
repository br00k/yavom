<?php

/**
 * Principal form base class.
 *
 * @method Principal getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePrincipalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fedid'             => new sfWidgetFormInputText(),
      'role_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
      'organization_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Organization')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fedid'             => new sfValidatorString(array('max_length' => 255)),
      'role_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
      'organization_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Organization', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Principal', 'column' => array('fedid')))
    );

    $this->widgetSchema->setNameFormat('principal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Principal';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['role_list']))
    {
      $this->setDefault('role_list', $this->object->Role->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['organization_list']))
    {
      $this->setDefault('organization_list', $this->object->Organization->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveRoleList($con);
    $this->saveOrganizationList($con);

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
