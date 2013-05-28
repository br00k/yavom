<?php

/**
 * updateEntitlementPackEntitlement actions.
 *
 * @package    sf_sandbox
 * @subpackage updateEntitlementPackEntitlement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class updateEntitlementPackEntitlementActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     $r = Doctrine::getTable('EntitlementPack')->find($request->getParameter('id'));
     $this->forward404Unless($r->getService()->isMy());

     $defaults = array();
     foreach ($r->getEntitlement() as $e){
       $defaults[]=$e->getId();
     }

     $this->form = new ServEntitlementPackEntitlementForm(array(
        	'entitlement_id'=>$defaults,
	        'entitlementpack_id'=>$r->getId(),
	),
	array(
		"s_id"=>$r->getServiceId(),
	)
	);
     $this->r = $r;
  }

  public function executeProcessForm(sfWebRequest $request)
  {
     $r = Doctrine::getTable('EntitlementPack')->find($request->getParameter('entitlementpack_id'));
     $this->forward404Unless($r->getService()->isMy());

     foreach($r->getEntitlementPackEntitlement() as $re){
       $re->delete();
     }
     foreach ($request->getParameter('entitlement_id') as $e_id){
       $e = Doctrine::getTable('Entitlement')->createQuery()->where('id',$e_id)->execute();
       $connected = FALSE;
       foreach ($e as $os)
       {
         if ($os->getServiceId() == $r->getServiceId())
         {
           $connected = TRUE;
           break;
         }
       }
       $this->forward404Unless($connected);
       $re = new EntitlementPackEntitlement();
       $re->setEntitlementId($e_id);
       $re->setEntitlementPackId($r->getId());
       $re->save();
     }
     $this->redirect("show/index?id=".$r->getService()->getId());
  }
}
