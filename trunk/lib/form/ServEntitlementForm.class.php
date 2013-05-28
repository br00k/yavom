<?php

/**
 * Entitlement form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ServEntitlementForm extends EntitlementForm
{
  public function configure()
  {
    $this->widgetSchema['service_id'] = new sfWidgetFormInputHidden();
    unset($this["role_list"], $this["entitlement_pack_list"]);
    
  
    parent::configure();
  }
}
