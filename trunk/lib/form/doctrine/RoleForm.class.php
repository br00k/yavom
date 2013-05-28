<?php

/**
 * Role form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RoleForm extends BaseRoleForm
{
  public function configure()
  {
    //$this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCECustom();
    $this->widgetSchema['description'] = new sfWidgetFormTextarea();
    $this->widgetSchema->setLabel('description', 'Szerepkör leírása, céljai');
  }
}
