<?php

/**
 * Entitlement form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EntitlementForm extends BaseEntitlementForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['description'] = new sfWidgetFormTextarea();
    //$this->widgetSchema->setLabel('description', 'Jogosultság leírása');
    //$this->widgetSchema->setLabel('name', 'Jogosultság neve');
    $this->widgetSchema->setLabel('uri',$i18n-> __('Value of the eduPersonEntitlement attribute'));
    $this->widgetSchema['uri']->setAttribute('style', 'width: 95%');
    unset($this["created_at"]);
    unset($this["updated_at"]);
  }
}
