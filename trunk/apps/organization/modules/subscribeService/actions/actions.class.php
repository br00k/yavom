<?php

/**
 * subscribeService actions.
 *
 * @package    sf_sandbox
 * @subpackage subscribeService
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class subscribeServiceActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $o = Doctrine::getTable('Organization')->find($request->getParameter("id"));
    $oss = $o->getService();
    $bss = Doctrine::getTable('EntitlementPack')->findByType('browseable');
    $bs_ids = array();
    $os_ids = array();
    foreach ($bss as $bs )
    {
      $bs_ids[] = $bs->getId();
    }
    foreach ($oss as $os )
    {
      $os_ids[] = $os->getId();
    }
    $diff_ids = array_diff($bs_ids,$os_ids);

    $this->oe = array();
    foreach ($diff_ids as $id)
    {
      $this->oe[] = Doctrine::getTable('EntitlementPack')->find($id);
    }
    $this->o = $o;
  }

  public function executeSubscribe(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $o = Doctrine::getTable('Organization')->find($request->getParameter("oid"));
    $fromp = Doctrine::getTable('Principal')->find($request->getParameter('from'));
    if (! $o->isMy())
    {
      $m=__("Insufficent rights");;
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    if ($request->getParameter("eid"))
    {
      $e = Doctrine::getTable('EntitlementPack')->find($request->getParameter("eid"));
      $s = Doctrine::getTable('Service')->find($e->getServiceId());
      

      $oe = new OrganizationEntitlementPack();
      $oe->setOrganization($o);
      $oe->setEntitlementPack($e);
      $oe->setStatus("pending");
      $oe->save(); 
      
      
      $sendto = $s->getManagersEmailArray();
      
      $mail = $this->getMailer()->compose(array($fromp->getEmail()=>$fromp->getName()), $sendto, $i18n->__(ProjectConfiguration::$mail_tag.'Organization %organization% would like to subscribe to %service%::%ep%',array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$e->getName())));
      $html  = $this->getPartial('subscribeService/subscribeHtml', array('p' => $fromp, 'o'=>$o, "s"=> $s, "ep"=>$e));
      $mail->setBody($html, 'text/html');

      $this->getMailer()->send($mail);
    }
    

    if ($request->getParameter("token"))
    {
      $e = Doctrine::getTable('EntitlementPack')->findOneByToken($request->getParameter("token"));
      $s = Doctrine::getTable('Service')->find($e->getServiceId());

      if (! $e){
        $m=__("Invalid token");
        $this->getUser()->setFlash('error',$m);
        $this->redirect("default/error");
      }

      $loe = $o->getOrganizationEntitlementPack();
      foreach( $loe as $oe){
        if($oe->getEntitlementPackId() == $e->getId()){
          $m=__('The service is already connected');
          $this->getUser()->setFlash('notice',$m);
          $this->redirect("show/index?id=".$o->getId());
        }
      } 
      

      $oe = new OrganizationEntitlementPack();
      $oe->setOrganization($o);
      $oe->setEntitlementPack($e);
      $oe->setStatus("accepted");
      $oe->save(); 
      
      $sendto = $s->getManagersEmailArray();
      
      $mail = $this->getMailer()->compose(array($fromp->getEmail()=>$fromp->getName()), $sendto, $i18n->__(ProjectConfiguration::$mail_tag.'Organization %organization% has subscribed to %service%::%ep% using token',array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$e->getName())));
      $html  = $this->getPartial('subscribeService/subscribeTokenHtml', array('p' => $fromp, 'o'=>$o, "s"=>$s, "ep"=>$e));
      $mail->setBody($html, 'text/html');

      $this->getMailer()->send($mail);
      
    }
    
    $sendto = $o->getManagersEmailArray();
    
    $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $sendto, $i18n->__(ProjectConfiguration::$mail_tag.'Organization %organization% has subscribed to %service%::%ep%',array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$e->getName())));
      $html  = $this->getPartial('subscribeService/subscribeOrgHtml', array('o'=>$o, "s"=>$s, "ep"=>$e));
      $mail->setBody($html, 'text/html');

      $this->getMailer()->send($mail);

    $this->redirect("show/index?id=".$o->getId());
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    //TODO
  }
  
}
