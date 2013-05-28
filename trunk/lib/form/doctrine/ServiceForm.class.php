<?php

/**
 * Service form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ServiceForm extends BaseServiceForm
{

  public function configure()
  {

    $metadata = SimpleSAML_Metadata_MetaDataStorageHandler::getMetadataHandler();
    $entitylist = $metadata->getList('saml20-sp-remote');
    foreach ($entitylist as $key=>$value){
      $spidlist[$key] = $key;
    }

    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['description'] = new sfWidgetFormTextarea();
    $this->widgetSchema['entityId'] = new sfWidgetFormChoice(array(
        'choices'  => $spidlist,
        //'expanded' => true,
      ));


    $this->widgetSchema->setLabel('description', $i18n->__('Service description'));
    $this->widgetSchema->setLabel('url', $i18n->__('Service homepage'));
    $this->widgetSchema->setLabel('entityId', $i18n->__('SAML SP entity id'));
    $this->widgetSchema->setLabel('name', $i18n->__('Service name'));
    //$this->widgetSchema->setLabel('type', $i18n->__('Registration type'));


    unset($this['type']);
    unset($this['organization_list']);
    unset($this['principal_id']);
    unset($this['created_at']);
    unset($this['updated_at']);
    unset($this['token']);

  }
}
