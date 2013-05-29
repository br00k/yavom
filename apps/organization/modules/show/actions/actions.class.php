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
    $this->o = Doctrine::getTable('Organization')->find($request->getParameter('id'));
    if (! $this->o->amIRelated())
    {
      $m=$i18n->__("You have no rights to access this organization.");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
/*
    $rs = $this->o->getRole();
    foreach ($rs as $r){
      var_dump($r->getName());
    }
    exit;
    $update_org_form_defaults = array(
        'id'=>$this->o->getId(),
        'name'=>$this->o->getName(),
        'description'=>$this->o->getDescription(),
        'default_role_id'=>$this->o->getDefaultRoleId(),
    );
*/  $this->eps = Doctrine_Query::create()
                        ->from('EntitlementPack ep')
                        ->leftJoin('ep.OrganizationEntitlementPack oe')
                        ->where('oe.organization_id = ?', $this->o->getId())->execute();

    $this->rs = $this->o->getRole();
    $this->send_mail_form = new OrgMailerForm(null, array('o_id'=>$this->o->getId()));
    $this->send_mail_form->setDefault('o_id',$this->o->getId());
    $this->send_mail_form->setDefault('from',$this->getUser()->getPrincipal()->getId());
    $this->principalform = new OrgRolePrincipalForm();
    $this->entitlementform = new OrgRoleEntitlementForm();
    $this->create_role_form = new OrgRoleForm();
    //$this->update_org_form = new OrganizationForm($update_org_form_defaults);
    $this->update_org_form = new OrganizationForm($this->o);
  }
  
  public function executeDeleteRole(sfWebRequest $request)
  {
    $r = Doctrine::getTable('Role')->find($request->getParameter('id'));
    $this->forward404Unless($r->getOrganization()->isMy());
    $o_id=$r->getOrganization()->getId();

    $r->delete();
    $this->redirect("show/index?id=".$o_id);
  }
  
  public function executeSendMail(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $o=Doctrine::getTable('Organization')->find($request->getParameter('o_id'));
    $fromp = Doctrine::getTable('Principal')->find($request->getParameter('from'));
    $ids = $request->getParameter('ids');
    $sendto=array();
    foreach($ids as $id)
    {
      $r = Doctrine::getTable('Role')->find($id);
      
      $sendto = $r->getMembersEmailArray();
      
      $mail = $this->getMailer()->compose(array($fromp->getEmail()=>$fromp->getName()), $sendto, $i18n->__(ProjectConfiguration::$mail_tag.'Message from organization %organization%',array("%organization%"=>$o)));
    
      $html  = $this->getPartial('show/msgHtml', array('p' => $fromp, 'o'=>$o, 'r'=>$r, 'm'=>$request->getParameter('message')));
      $mail->setBody($html, 'text/html');
      
      $this->getMailer()->send($mail);
    }
    
    
    
    $this->getUser()->setFlash('notice', $i18n->__('The message has been sent.'));
    
    $this->redirect("show/index?id=".$o->getId());
  
  }

  public function executeProcessNewOrgRoleForm(sfWebRequest $request)
  {
    $o = Doctrine::getTable('Organization')->find($request->getParameter('id'));
    $this->forward404Unless($o->isMy());

    $r = new Role();
    $r->setName($request->getParameter("name"));
    $r->setOrganizationId($o->getId());
    $r->setDescription($request->getParameter("description"));
    $r->save();

    $this->redirect("show/index?id=".$o->getId());
  }

  public function executeProcessUpdateOrgRoleForm(sfWebRequest $request)
  {
    $r = Doctrine::getTable('Role')->find($request->getParameter('id'));
    $this->forward404Unless($r->getOrganization()->isMy());

    $r->setName($request->getParameter("name"));
    $r->setDescription($request->getParameter("description"));
    $r->save();

    $this->redirect("show/index?id=".$r->getOrganization()->getId());
  }
  
  public function executeUnlinkOrganization(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    //$request->checkCSRFProtection();
    $e = Doctrine::getTable('EntitlementPack')->find($request->getParameter('eid'));
    $o = Doctrine::getTable('Organization')->find($request->getParameter('oid'));

    $o->isMy();

    if ($request->getParameter("confirm") != $i18n->__("Yes, do as I say!"))
    {
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement pack has not been unlinked.'));
      $this->redirect('show/index?id='.$o->getId());
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
      foreach($o->getRole() as $role){
	$role->updateEntitlements($o->getId());
      }
      //Frissítenünk kell a szervezet szerepköreit, hogy kikerüljenek a már elérhetetlenné vált jogosultságok
     /* $q = Doctrine_Query::create()
                        ->from('Entitlement e')
                        ->leftJoin('e.EntitlementPackEntitlement epe')
                        ->leftJoin('epe.EntitlementPack ep')
                        ->leftJoin('ep.OrganizationEntitlementPack oe')
                        ->where('oe.organization_id = ?', $o->getId())
                        ->andWhere('oe.status = ?', 'accepted')->execute();
      $roles = Doctrine_Query::create()->from('RoleEntitlement re')->leftJoin('re.Role r')->where('r.organization_id = ?', $o->getId())->execute();
      foreach($roles as $r){
        $torolni = true;
	foreach ($q as $qe){
	  if ($qe->getId() == $r->getEntitlementId()) { $torolni = false; }
	}
	if ($torolni) { $r->delete(); }
      }*/
      
      $s = Doctrine::getTable('Service')->find($e->getServiceId());
      $sendto = $s->getManagersEmailArray();
      
      $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $sendto, $i18n->__(ProjectConfiguration::$mail_tag.'Organization %organization% has deleted its subscription to %service%::%ep%',array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$e->getName())));
      $html  = $this->getPartial('show/unsubscribeHtml', array('o'=>$o, "s"=>$s));
      $mail->setBody($html, 'text/html');

      $this->getMailer()->send($mail);
      
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement pack has been successfully unlinked'));
      
      $sendto = $o->getManagersEmailArray();
    
      $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $sendto, $i18n->__(ProjectConfiguration::$mail_tag.'Organization %organization% has deleted its subscription to %service%::%ep%',array("%organization%"=>$o, "%service%"=>$s, "%ep%"=>$e->getName())));
      $html  = $this->getPartial('show/unsubscribeOrgHtml', array('o'=>$o, "s"=>$s));
      $mail->setBody($html, 'text/html');

      $this->getMailer()->send($mail);
    }
    $this->redirect('show/index?id='.$o->getId());

  }
  public function executeProcessUpdateOrgForm(sfWebRequest $request)
  {
    $o_array = $request->getParameter('organization');
    $o = Doctrine::getTable('Organization')->find($o_array['id']);
    $this->forward404Unless($o->isMy());

    if ($o_array['default_role_id'] == "")
      $o->setDefaultRoleId(NULL);
    else
      $o->setDefaultRoleId($o_array["default_role_id"]);
    $o->setName($o_array["name"]);
    $o->setDescription($o_array["description"]);
    $o->save();

    $this->redirect("show/index?id=".$o->getId());
  }
  public function executeRoleReorder(sfWebRequest $request)
  {
    $order_array = $request->getParameter('id');
    $r = Doctrine::getTable('Role')->find($order_array[0]);
    $this->forward404Unless($r->getOrganization()->isMy());

    foreach ($order_array as $order=>$r_id)
    {
      $r = Doctrine::getTable('Role')->find($r_id);
      $r->setShoworder($order);
      $r->save();
    }
    return sfView::SUCCESS;
  }
  public function executeUnlinkPrincipal(sfWebRequest $request)
  {
    $i_id = $request->getParameter('id');
    $i = Doctrine::getTable('Invitation')->find($i_id);
    $o = $i->getOrganization();
    $this->forward404Unless($o->isMy());
    $target_id = $i->getPrincipalId();
    $rs = $i->getOrganization()->getRole();
    foreach ($rs as $r){
      //echo "<hr>";
      //echo $r->getName()."<br>";
      foreach ($r->getRolePrincipal() as $rp){
        //echo $rp->getPrincipal()->getName();
        if ($rp->getPrincipalId() == $target_id){
          //echo " ****TÖRÖLNI";
          $rp->delete();
        }
        //echo "<br>";
      }
    }
    //echo "<hr>Menedzserek<br>";
    foreach ($o->getOrganizationPrincipal() as $op){
      //echo $op->getPrincipal()->getName();
      if ($op->getPrincipalId() == $target_id){
        //echo " ****TÖRÖLNI";
        $op->delete();
      }
      //echo "<br>";
    }
    $i->delete();
    //var_dump($i->getPrincipal()->getName()); exit;
    $this->redirect("show/index?id=".$o->getId());
  }
}
