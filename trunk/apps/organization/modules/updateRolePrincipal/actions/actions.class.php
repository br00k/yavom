<?php

/**
 * updateRolePrincipal actions.
 *
 * @package    sf_sandbox
 * @subpackage updateRolePrincipal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class updateRolePrincipalActions extends sfActions
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
     $this->form = new OrgRolePrincipalForm(array(),array("o_id"=>$r->getOrganizationId()));
     $this->r = $r;
     $this->getUser()->setFlash('referer', 'updateRolePrincipal/index?id='.$r->getId());
  }

  public function executeProcessForm(sfWebRequest $request)
  {
     $i18n = sfContext::getInstance()->getI18N();
     $r = Doctrine::getTable('Role')->find($request->getParameter('role_id'));
     $torolve = array();
     $uj = array();
     $this->forward404Unless($r->getOrganization()->isMy());
     foreach($r->getRolePrincipal() as $rp){
       $megmarad = FALSE;
       foreach ($request->getParameter('principal_id') as $p_id){
         if ($rp->getPrincipalId() == $p_id){
           $megmarad = TRUE;
         } 
       }
       if (!$megmarad){
         array_push($torolve, $rp->getPrincipalId());
         $rp->delete();
       }
     }
     $exparray = $request->getParameter('expiration');
     $expstring = $exparray['year']."-".$exparray['month']."-".$exparray['day'].' 00:00:00';
     foreach ($request->getParameter('principal_id') as $p_id){
       $ezmarvolt=FALSE;;
       foreach($r->getRolePrincipal() as $rp){
         if ($rp->getPrincipalId() == $p_id){
           // ez már egyszer fel van véve.
           $ezmarvolt=TRUE;;
         }
       }
       if (!$ezmarvolt){
         $rp = new RolePrincipal();
         $rp->setPrincipalId($p_id);
         $rp->setRoleId($r->getId());
         $rp->setExpiration($expstring);
         $rp->save();
         array_push($uj,$rp->getPrincipalId());
       }
     }
     /**
     * Mail to deleted principals
     */
     $to = array();
     foreach($torolve as $tpid){
       $tp = Doctrine::getTable('Principal')->find($tpid);
       $to[$tp->getEmail()] = $tp->getName();
     }
     
     $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $to, $i18n->__(ProjectConfiguration::$mail_tag.'Your membership in %organization::%role% has been cancelled',array("%role%"=>$r->getName(), "%organization%"=>$r->getOrganization())));
     $html  = $this->getPartial('updateRolePrincipal/cancelledHtml', array("o"=>$r->getOrganization(), "r"=>$r));
     $mail->setBody($html, 'text/html');

     $this->getMailer()->send($mail);
     
     /**
     * Mail to added principals
     */
     $to = array();
     foreach($uj as $tpid){
       $tp = Doctrine::getTable('Principal')->find($tpid);
       $to[$tp->getEmail()] = $tp->getName();
     }
     
     $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $to, $i18n->__(ProjectConfiguration::$mail_tag.'Welcome to role %organization::%role%',array("%role%"=>$r->getName(), "%organization%"=>$r->getOrganization())));
     $html  = $this->getPartial('updateRolePrincipal/addedHtml', array("o"=>$r->getOrganization(), "r"=>$r));
     $mail->setBody($html, 'text/html');

     $this->getMailer()->send($mail);
     
     /**
     * Mail to organization maganers
     */
     $to = $r->getOrganization()->getManagersEmailArray();
     $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $to, $i18n->__(ProjectConfiguration::$mail_tag.'Members of the %organization::%role% role have been modified',array("%role%"=>$r->getName(), "%organization%"=>$r->getOrganization())));
     $html  = $this->getPartial('updateRolePrincipal/managersHtml', array("o"=>$r->getOrganization(), "r"=>$r));
     $mail->setBody($html, 'text/html');

     $this->getMailer()->send($mail);
     
     $this->redirect("show/index?id=".$r->getOrganization()->getId());
  }
}
