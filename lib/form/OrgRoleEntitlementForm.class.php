<?php

class OrgRoleEntitlementForm extends BaseForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
   $q = Doctrine_Query::create()
                        ->select('e.id')
                        ->from('Entitlement e')
                        ->leftJoin('e.EntitlementPackEntitlement epe')
                        ->leftJoin('epe.EntitlementPack ep')
                        ->leftJoin('ep.OrganizationEntitlementPack oe')
                        ->where('oe.organization_id =?', $this->getOption('o_id'))
                        ->andWhere('oe.status = ?', 'accepted');

    $this->setWidgets(array(
      'entitlement_id'   => new sfWidgetFormDoctrineChoice( array(
        'model' => 'Entitlement',
        'renderer_class' => 'sfWidgetFormSelectDoubleList',
        'label' => $i18n->__('Connect entitlements'),
        'query' => $q,
        'renderer_options' => array(
          'label_associated' => $i18n->__('Associated entitlements'),
          'label_unassociated' => $i18n->__('Not associated entitlements'),
          'associate' => '<img src="/sf/sf_admin/images/previous.png" alt="associate" />',
          'unassociate'=> '<img src="/sf/sf_admin/images/next.png" alt="unassociate" />',
	),
      )),
      'role_id'   => new sfWidgetFormInputHidden( array()),
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
