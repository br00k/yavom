<?php

class ServEntitlementPackEntitlementForm extends BaseForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
   $q = Doctrine_Query::create()
                        ->select('e.id')
                        ->from('Entitlement e')
                        ->leftJoin('e.Service s')
                        ->where('s.id =?', $this->getOption('s_id'));

    $this->setWidgets(array(
      'entitlement_id'   => new sfWidgetFormDoctrineChoice( array(
        'model' => 'Entitlement',
        'renderer_class' => 'sfWidgetFormSelectDoubleList',
        'label' => $i18n->__('Connect entitlements'),
        'query' => $q,
        'renderer_options' => array(
          'label_associated' => $i18n->__('Associated entitlements'),
          'label_unassociated' => $i18n->__('Not associated entitlements'),
          'associate' => '<img src="/vo-dev/sfFormExtraPlugin/images/previous.png" alt="associate" />',
          'unassociate'=> '<img src="/vo-dev/sfFormExtraPlugin/images/next.png" alt="unassociate" />',
	),
      )),
      'entitlementpack_id'   => new sfWidgetFormInputHidden( array()),
    ));
    $this->setValidators(array(
      'entitlement_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Entitlement',
      )),
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
    ));
  }
}

?>
