<?php

class OrgPrincipalForm extends BaseForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
    /* csak azok jöhetnek akik az inviteolva vannak és már acceptedek.*/
    $q = Doctrine_Query::create()
                        ->select('i.id')
                        ->from('Invitation i')
                        ->where('i.organization_id =?', $this->getOption('o_id'))
                        ->andWhere('i.status = ?', 'accepted');
    $this->setWidgets(array(
      'principal_id'   => new sfWidgetFormDoctrineChoice( array(
        'model' => 'Invitation',
        'method' => 'getPrincipalName',
        'key_method' => 'getPrincipalId',
        'query' => $q,
        'label' => $i18n->__('Organization  managers'),
        'renderer_class' => 'sfWidgetFormSelectDoubleList',
        'renderer_options' => array(
          'label_associated' => $i18n->__('Associated managers'),
          'label_unassociated' => $i18n->__('Non-associated managers'),
          'unassociate' => '<img src="/sf/sf_admin/images/next.png" alt="unassociate" />',
          'associate'=> '<img src="/sf/sf_admin/images/previous.png" alt="associate" />',
       ))),
      'organization_id'   => new sfWidgetFormInputHidden( array()),
    ));
    $this->setValidators(array(
      'principal_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Invitation',
      )),
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
    ));
  }
}

?>
