<?php

class OrgRolePrincipalForm extends BaseForm
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
        'label' => $i18n->__('Connect members'),
        'query' => $q,
        'renderer_class' => 'sfWidgetFormSelectDoubleList',
        'renderer_options' => array(
          'label_associated' => $i18n->__('Associated members'),
          'label_unassociated' => $i18n->__('Non-associated members'),
          'associate' => '<img src="/vo-dev/sfFormExtraPlugin/images/previous.png" alt="associate" />',
          'unassociate'=> '<img src="/vo-dev/sfFormExtraPlugin/images/next.png" alt="unassociate" />',
        ),
      )),
      'role_id'   => new sfWidgetFormInputHidden( array()),
      /*'expiration'   => new sfWidgetFormJQueryDate( array(
        'label' => 'Kinevezés lejárata',
        'culture' => 'hu',
      )),*/
    ));
    $this->setValidators(array(
      'principal_id' => new sfValidatorDoctrineChoice(array(
        'model' => 'Invitation',
      )),
      $this->getCSRFFieldName() => new sfValidatorCSRFToken(array(
        'token' => $this->getCSRFToken(),
      )),
      'expiration' => new sfValidatorDate(array(
      )),
    ));
  }
}

?>
