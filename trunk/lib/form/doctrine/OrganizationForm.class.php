<?php

/**
 * Organization form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrganizationForm extends BaseOrganizationForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
     $q =  Doctrine_Query::create();
     $q ->select('r.id')
        ->from('Role r')
        ->where('r.organization_id = ' .$this->getObject()->getId());

    //$this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCECustom();
    $this->widgetSchema['description'] = new sfWidgetFormTextarea();
    $this->widgetSchema['role_name'] = new sfWidgetFormInputText();
    $this->widgetSchema['default_role_id'] = new sfWidgetFormDoctrineChoice(
                array(
                    'model' => 'Role',
                    'add_empty' => true,
                    'query' => $q,
                    'method' => 'getName',
                )
           );
    $this->widgetSchema->setLabel('description', $i18n->__('Organization description'));
    $this->widgetSchema->setLabel('name', $i18n->__('Organization name'));
    $this->widgetSchema->setLabel('role_name', $i18n->__('Default role name'));

    $this->validatorSchema['role_name'] = new sfValidatorString(array('max_length' => 255,'required' => false));
  }
}
