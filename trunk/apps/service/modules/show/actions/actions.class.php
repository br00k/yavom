<?php

/**
 * show actions.
 *
 * @package    sf_sandbox
 * @subpackage show
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class showActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $this->s = Doctrine::getTable('Service')->find($request->getParameter('id'));
    //TODO jogosultsagvizsgalat, csak aki tag vagy menedzser.
    if (! $this->s->isMy())
    {
      $m=$i18n->__("Insufficent rights");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    $this->form = new SendTokenForm();
    $this->rs = $this->s->getEntitlementPack();
    $this->entitlementform = new ServEntitlementPackEntitlementForm();
    $this->create_entitlementpack_form = new ServEntitlementPackForm();
    $this->form->setDefault("s_id",$this->s->getId()); 
  }

  public function executeAcceptOrganization(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $ep = Doctrine::getTable('EntitlementPack')->find($request->getParameter('eid'));
    $s = Doctrine::getTable('Service')->find($ep->getServiceId());
    $o = Doctrine::getTable('Organization')->find($request->getParameter('oid'));
    $q = Doctrine_Query::create()
        ->from('OrganizationEntitlementPack oe')
        ->where('oe.organization_id = ?',$o->getId())
        ->andWhere('oe.entitlement_pack_id = ?',$ep->getId());
 
    $oss = $q->execute();
    $os = $oss[0];

    if ($request->getParameter("accept"))
    {

      $os->setStatus("accepted");
      $os->save();

      $sendto = $o->getManagersEmailArray();

      $emailparams = (array(
        "subject"=>$i18n->__('Service subsrciption request accepted'),
        "to"=>$sendto,
        "bodyhtml"=>$this->getPartial("subscribeAcceptedHtml",array("s"=>$s, "ep"=>$ep))
	));
      $this->sendEmail($emailparams);
    
      $this->getUser()->setFlash("notice",$i18n->__('Accepted'));
      $this->redirect("show/index?id=".$s->getId());
    }
    if ($request->getParameter("deny"))
    {
      $this->getUser()->setFlash("notice",$i18n->__('Denied'));
      $os->delete();

      $sendto = $o->getManagersEmailArray();

      $emailparams = (array(
        "subject"=>$i18n->__('Service subsrciption request denied'),
        "to"=>$sendto,
        "bodyhtml"=>$this->getPartial("subscribeDeniedHtml",array("s"=>$s))
	));

      $this->redirect("show/index?id=".$s->getId());
    }
  }
  
  public function executeUnlinkOrganization(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $i18n = sfContext::getInstance()->getI18N();
    $e = Doctrine::getTable('EntitlementPack')->find($request->getParameter('eid'));
    $o = Doctrine::getTable('Organization')->find($request->getParameter('oid'));
    $sid = $e->getServiceId();

    $e->getService()->isMy();

    if ($request->getParameter("confirm") != $i18n->__("Yes, do as I say!"))
    {
      $this->getUser()->setFlash('notice', __('The entitlement package has not been deleted.'));
      $this->redirect('show/index?id='.$sid);
    }
    
    $oes = Doctrine_Query::create()->from('OrganizationEntitlementPack oe')->where('organization_id = ?', $o->getId())
      ->andWhere('entitlement_pack_id = ?', $e->getId())->execute();
    
    $delete_this = NULL;
    
    foreach($oes as $oe) {
      if ($oe->getOrganizationId() == $o->getId()) {$delete_this = $oe;}
    }

    //$this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $delete_this)));

    if ($delete_this->delete())
    {
      //Frissítenünk kell a szervezet szerepköreit, hogy kikerüljenek a már elérhetetlenné vált jogosultságok
      foreach($o->getRole() as $role){
	$role->updateEntitlements($o->getId());
      }
      
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement pack has been deleted.'));
    }
    $this->redirect('show/index?id='.$sid);
  }

  public function executeSendToken(sfWebRequest $request){
    $i18n = sfContext::getInstance()->getI18N();
    $s = Doctrine::getTable('Service')->find($request->getParameter('s_id'));
    $ep = Doctrine::getTable('EntitlementPack')->find($request->getParameter('ep_id'));
    $params = (array(
     "subject"=>$i18n->__('Secret token for %ep% entitlement pack', array("%ep%"=>$ep->getName())),
     "to"=>array($request->getParameter('email')=>""),
     "bodyhtml"=>$this->getPartial("sendTokenHtml",array("p"=>$this->getUser()->getPrincipal(),"s"=>$s, "ep"=>$ep, "m"=>$request->getParameter("message")))));
    
    $this->sendEmail($params); 
    $this->getUser()->setFlash("notice",$i18n->__("Secret token sent.")." ".$s->getId()." ".$ep->getId());
    $this->redirect("show/index?id=".$s->getId());

  }
  
  
  public function executeProcessNewServEntitlementPackForm(sfWebRequest $request)
  {
    $s = Doctrine::getTable('Service')->find($request->getParameter('id'));
    $this->forward404Unless($s->isMy());

    $r = new EntitlementPack();
    $r->setName($request->getParameter("name"));
    $r->setServiceId($s->getId());
    $r->setDescription($request->getParameter("description"));
    $r->save();

    $this->redirect("show/index?id=".$s->getId());
  }
  
  public function executeProcessUpdateServEntitlementPackForm(sfWebRequest $request)
  {
    $r = Doctrine::getTable('EntitlementPack')->find($request->getParameter('id'));
    $this->forward404Unless($r->getService()->isMy());

    $r->setName($request->getParameter("name"));
    $r->setDescription($request->getParameter("description"));
    $r->save();

    $this->redirect("show/index?id=".$r->getService()->getId());
  }
  
  public function executeEntitlementPackReorder(sfWebRequest $request)
  {
    $order_array = $request->getParameter('id');
    $r = Doctrine::getTable('EntitlementPack')->find($order_array[0]);
    $this->forward404Unless($r->getService()->isMy());

    foreach ($order_array as $order=>$r_id)
    {
      $r = Doctrine::getTable('EntitlementPack')->find($r_id);
      $r->setShoworder($order);
      $r->save();
    }
    return sfView::SUCCESS;
  }
  
  public function executeDeleteEntitlementPack(sfWebRequest $request)
  {
    $r = Doctrine::getTable('EntitlementPack')->find($request->getParameter('id'));
    $this->forward404Unless($r->getService()->isMy());
    $s_id=$r->getService()->getId();

    $r->delete();
    $this->redirect("show/index?id=".$s_id);
  }

  /**
   $params = (array(
     "subject"=>NULL,
     "to"=>NULL,
     "from"=>array(
          "email"=>NULL,
          "name"=>NULL),
     "bodyhtml"=>NULL));
  */
  public function sendEmail($params)
  {
    $message = $this->getMailer()->compose();
    $message->setSubject(ProjectConfiguration::$mail_tag.$params['subject']);
    $message->setTo($params['to']);
    $message->setFrom(ProjectConfiguration::$mail_from);

    $message->setBody($params['bodyhtml'], 'text/html');
//TODO    $text = $this->getPartial('invitePrincipal/inviteTxt',$params);
//    $message->addPart($text, 'text/plain');    

    $this->getMailer()->send($message);
  }
  
  public function executeUnlinkPrincipal(sfWebRequest $request)
  {
    $i_id = $request->getParameter('id');
    $i = Doctrine::getTable('ServiceInvitation')->find($i_id);
    $s = $i->getService();
    $this->forward404Unless($s->isMy());
    $target_id = $i->getPrincipalId();
    
    //echo "<hr>Menedzserek<br>";
    foreach ($s->getServicePrincipal() as $sp){
      //echo $op->getPrincipal()->getName();
      if ($sp->getPrincipalId() == $target_id){
        //echo " ****TÖRÖLNI";
        $sp->delete();
      }
      //echo "<br>";
    }
    $i->delete();
    //var_dump($i->getPrincipal()->getName()); exit;
    $this->redirect("show/index?id=".$s->getId());
  }
  
  public function executeDeleteManager(sfWebRequest $request){
    $i18n = sfContext::getInstance()->getI18N();
    $sid = $request->getParameter('s_id');
    $pid = $request->getParameter('p_id');
    $s = Doctrine::getTable('Service')->find($sid);
    $this->forward404Unless($s->isMy());
  
    $q = Doctrine_Query::create()
                        ->from('ServicePrincipal sp')
                        ->where('sp.service_id = ?', $sid)
                        ->andWhere('sp.principal_id = ?', $pid)->execute();
      
     if ($q->count()<1){
      $m=$i18n->__("No such manager/service pair!");
      $this->getUser()->setFlash('notice',$m);
      $this->redirect("show/index?id=".$sid);
    }
                     
    
    $sp = Doctrine_Query::create()
                        ->from('ServicePrincipal sp')
                        ->where('sp.service_id = ?', $sid)->execute();
                     
    if ($sp->count()<2){
      $m=$i18n->__("You can't delete the last manager!");
      $this->getUser()->setFlash('notice',$m);
      $this->redirect("show/index?id=".$sid);
    }
    
    
    
    foreach($sp as $manager){
      if($manager->getPrincipalId() == $pid){
        $manager->delete();
      } 
      }
    
    $si = Doctrine_Query::create()
                        ->from('ServiceInvitation si')
                        ->where('si.service_id = ?', $sid)->execute();
    
    foreach($si as $invs){
      if($invs->getPrincipalId() == $pid){
        $invs->delete();
      }
    }
    
    $m=$i18n->__('Manager deleted.');
    $this->getUser()->setFlash('notice',$m);
    $this->redirect("show/index?id=".$sid);
  }
}
