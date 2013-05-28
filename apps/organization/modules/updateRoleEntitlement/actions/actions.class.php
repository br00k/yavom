<?php

/**
 * updateRoleEntitlement actions.
 *
 * @package    sf_sandbox
 * @subpackage updateRoleEntitlement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class updateRoleEntitlementActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     $r = Doctrine::getTable('Role')->find($request->getParameter('id'));
     $this->forward404Unless($r->getOrganization()->isMy());

     $defaults = array();
     foreach ($r->getEntitlement() as $e){
       $defaults[]=$e->getId();
     }

     $this->form = new OrgRoleEntitlementForm(array(
        	'entitlement_id'=>$defaults,
	        'role_id'=>$r->getId(),
	),
	array(
		"o_id"=>$r->getOrganizationId(),
	)
	);
     $this->r = $r;
  }

  public function executeProcessForm(sfWebRequest $request)
  {
     $i18n = sfContext::getInstance()->getI18N();
     $r = Doctrine::getTable('Role')->find($request->getParameter('role_id'));
     $this->forward404Unless($r->getOrganization()->isMy());

     foreach($r->getRoleEntitlement() as $re){
       $re->delete();
     }
     foreach ($request->getParameter('entitlement_id') as $e_id){
       $e = Doctrine::getTable('Entitlement')->find($e_id);
       $connected = FALSE;
       /*foreach ($e->getEntitlementPack()->getOrganizationEntitlementPack() as $os)
       {
         if ($os->getOrganizationId() == $r->getOrganizationId() and $os->getStatus() == 'accepted')
         {
           $connected = TRUE;
           break;
         }
       }*/
       foreach($e->getEntitlementPack() as $ep){
         foreach ($ep->getOrganizationEntitlementPack() as $os)
         {
           if ($os->getOrganizationId() == $r->getOrganizationId() and $os->getStatus() == 'accepted')
           {
             $connected = TRUE;
             break;
           }
         }
       }
       $this->forward404Unless($connected);
       $re = new RoleEntitlement();
       $re->setEntitlementId($e_id);
       $re->setRoleId($r->getId());
       $re->save();
       
       $to = $r->getOrganization()->getManagersEmailArray();
       $to += $r->getMembersEmailArray();
       
       $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $to, $i18n->__(ProjectConfiguration::$mail_tag.'Entitlements in role %organization%::%role% have been modified',array("%role%"=>$r->getName(), "%organization%"=>$r->getOrganization())));
       $html  = $this->getPartial('updateRoleEntitlement/modifiedHtml', array("o"=>$r->getOrganization(), "r"=>$r));
       $mail->setBody($html, 'text/html');

       $this->getMailer()->send($mail);
     }
     $this->redirect("show/index?id=".$r->getOrganization()->getId());
  }
}
