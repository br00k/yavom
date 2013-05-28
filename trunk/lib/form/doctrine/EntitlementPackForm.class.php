<?php

/**
 * EntitlementPack form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EntitlementPackForm extends BaseEntitlementPackForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['description'] = new sfWidgetFormTextarea();
    $this->widgetSchema->setLabel('description', $i18n->__('Pack description'));
    $this->widgetSchema->setLabel('name', $i18n->__('Pack name'));
    $this->widgetSchema->setLabel('token', $i18n->__('Subscribing token'));
    
    unset($this['showorder']);
    unset($this['created_at']);
    unset($this['entitlement_list']);
  }
}
