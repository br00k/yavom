<?php

/**
 * Organization form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrgMailerForm extends BaseForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
     $q =  Doctrine_Query::create()->select('r.id, r.name')
        ->from('Role r')
        ->where('r.organization_id = ?',$this->getOption('o_id'))->execute();
    foreach($q as $r){;
      $choices[$r['id']]=$r['name'];
    }

    $this->widgetSchema['o_id'] = new sfWidgetFormInputHidden( array(
        ));
     $this->widgetSchema['from'] = new sfWidgetFormInputHidden( array(
        ));
    
    $this->widgetSchema['ids'] = new sfWidgetFormChoice(
    array(
        'choices'   => $choices, 
        'multiple'  => true, 
        'expanded'  => true
        )
    );
    //$this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCECustom();
    $this->widgetSchema['message'] = new sfWidgetFormTextarea();
    
    $this->setValidators(array(
      'o_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Organization',
      )),
    ));
    
  }
}
