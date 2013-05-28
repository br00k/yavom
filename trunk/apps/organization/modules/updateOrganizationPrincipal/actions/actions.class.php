<?php

/**
 * updateOrganizationPrincipal actions.
 *
 * @package    sf_sandbox
 * @subpackage updateOrganizationPrincipal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class updateOrganizationPrincipalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     $o = Doctrine::getTable('Organization')->find($request->getParameter('id'));
     $this->forward404Unless($o->isMy());
     $this->form = new OrgPrincipalForm(array(),array("o_id"=>$o->getId()));
     $this->o = $o;
     $this->getUser()->setFlash('referer', 'updateOrganizationPrincipal/index?id='.$o->getId());
  }

  public function executeProcessForm(sfWebRequest $request)
  {
     $o = Doctrine::getTable('Organization')->find($request->getParameter('organization_id'));
     $this->forward404Unless($o->isMy());

     foreach($o->getOrganizationPrincipal() as $op){
       $op->delete();
     }
     foreach ($request->getParameter('principal_id') as $p_id){
       $op = new OrganizationPrincipal();
       $op->setPrincipalId($p_id);
       $op->setOrganizationId($o->getId());
       $op->save();
     }
     $this->redirect("show/index?id=".$o->getId());
  }
}
