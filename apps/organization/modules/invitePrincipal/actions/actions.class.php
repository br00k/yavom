<?php

/**
 * invitePrincipal actions.
 *
 * @package    sf_sandbox
 * @subpackage invitePrincipal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class invitePrincipalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $p = $this->getUser()->getPrincipal();

    $qpis = Doctrine_Query::create()
       ->from('Invitation i')
       ->where('i.principal_id = ?', $p->getId())
       ->andWhere('i.status = ?', 'pending');
 
    $qais = Doctrine_Query::create()
       ->from('Invitation i')
       ->where('i.principal_id = ?', $p->getId())
       ->andWhere('i.status = ?', 'accepted');

    $this->pis = $qpis->execute();
    $this->ais = $qais->execute();

  }

  public function executeInviteForm(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $o = Doctrine::getTable('Organization')->find($request->getParameter('o_id'));
    if (! $o)
    {
      $m=$i18n->__("Couldn't find the requested organization: id=%id%",array("%id%"=>$request->getParameter('o_id')));
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    if (! $o->isMy())
    {
      $m=$i18n->__('Only managers can invite new members.');
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    $role_id_choices = array();
    foreach ($o->getRole() as $r ){
      $role_id_choices[$r->getId()] = $r->getName();
    }
    $this->form = new InvitePrincipalForm(
       array(
           'o_id'=>$o->getId(),
           'role_id',$o->getDefaultRoleId(),
           ),
       array(
           'role_id_choices'=>$role_id_choices
           )
     );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $form = new InvitePrincipalForm();
    $a = $request->getParameter($form->getName());
    $oid = $a['o_id'];
    $form->bind($request->getParameter('invite'));
    if (! $form->isValid()) {
      $this->getUser()->setFlash('notice',$i18n->__('Could not send the invitation, please check the e-mail address and try again!'));
      $this->redirect("show/index?id=".$oid);
    }
    $emails = $form->getValue('email'); 
    $o_id  = $form->getValue('o_id');
    $role_id  = $form->getValue('role_id');
    $m = $form->getValue('message');
    $o = Doctrine::getTable('Organization')->find($o_id);
    $p = $this->getUser()->getPrincipal();

    foreach ($emails as $email)
    {
      $uuid = uniqid();
 
      $i = new Invitation();
      $i->setEmail($email);
      $i->setOrganization($o);
      $i->setUuid($uuid);
      $i->setCreatedAt(date('Y-m-d H:i:s'));
      $i->setCounter(1);
      $i->setInviter($p);
      $i->setStatus('pending');
      $i->setRoleId($role_id);
      $i->save();

      $r = $i->getRole();
      /* Send email */
      $params= array("i"=>$i, "m"=>$m, "o"=>$o, "p"=>$p,"r"=>$r, "reinvite"=>FALSE);
      $email_params=array(
        "to" => $i->getEmail(),
        "subject" => $i18n->__('Invitation to %organization% organization',array("%organization%"=>$o)),
        "bodyhtml" => $this->getPartial('invitePrincipal/inviteHtml',$params),
      );
  
      $this->sendEmail($email_params);
      
      $to = $o->getManagersEmailArray();
      
      $params= array("o"=>$o, "p"=>$p,"r"=>$r, "email"=>$email);
      $email_params=array(
        "to" => $to,
        "subject" => $i18n->__('Invitation of $email% to %organization% organization',array("%email%"=>$email, "%organization%"=>$o)),
        "bodyhtml" => $this->getPartial('invitePrincipal/inviteNoticeHtml',$params),
      );
  
      $this->sendEmail($email_params);
    }

    $this->getUser()->setFlash('notice',$i18n->__('The invitation has been sent.'));
    $this->redirect("show/index?id=".$o->getId());
  }

  public function executeResolve(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $i = Doctrine::getTable('Invitation')->findOneByUuid($request->getParameter('uuid'));

    /*  Nincs is ilyen meghívó. */
    if (! $i)
    {
      $m=$i18n->__("Can't find the requested invitation");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }

    /*  Elfogadta már? */
    if ($i->getStatus()!="pending")
    {
      $m=$i18n->__('The invitation is no longer pending: %status%', array("%status%"=>$i->getStatus()));
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }

    $p = Doctrine::getTable('Principal')->findOneByFedid($this->getUser()->getUsername());
    /* A felhasználó most van itt először. Berakjuk a principal-ba. */
    if (! $p)
    {
      $p = new Principal();
      $p->setFedid($this->getUser()->getUsername());
      $p->save();
    }

    /* Ugye nincs még benn a szervezetben? */
    $o = $i->getOrganization();
    foreach ($i->getPrincipal() as $prin)
    {
      if ($prin and $prin->getId() == $this->getUser()->getPrincipalId())
      {
        $i->delete();
        $m=$i18n->__('You are already a member of this organization. The invitation has lost its purpose, so we have deleted it.');
        $this->getUser()->setFlash('notice',$m);
        $this->redirect("show/index?id=".$r->getOrganization()->getId());
      }
    }

    $p_id = $this->getUser()->getPrincipalId();
    $i->setAcceptAt(date('Y-m-d H:i:s'));
    $i->setStatus('accepted');
    $i->setPrincipalId($p_id);
    $i->save();

    $rp = new RolePrincipal();
    $rp->setRoleId($i->getRoleId());
    $rp->setPrincipalId($p_id);
    $rp->save();
    
    $r = $rp->getRole();

    /* Send email */
    $params= array("o"=>$o, "p"=>$p, "r"=>$r);
    /* szervezők email címei */
    $to = array();
    foreach($o->getPrincipal() as $manager){
      $to[] = $manager->getUser()->getEmailAddress();
    }
    $email_params=array(
      "to" => $to,
      "subject" => $i18n->__('%lname% has accepted the invitation to %organization%', array("%lname"=>$p->getUser()->getLastName(),"%organization%"=>$o)),
      "bodyhtml" => $this->getPartial('invitePrincipal/acceptHtml',$params),
    );
    $this->sendEmail($email_params);

    $this->getUser()->setFlash('notice',$i18n->__('You have been successfully added to %organization% organization.', array("%organization%"=>$o)));
    $this->redirect("show/index?id=".$o->getId());
  }

  public function executeReinvite(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $i = Doctrine::getTable('Invitation')->find($request->getParameter('id'));
    if (! $i->getOrganization()->isMy())
    {
      $m=$i18n->__("Insufficent rights");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }

    $i->setCounter($i->getCounter()+1);
    $i->setLastReinviteAt(date('Y-m-d H:i:s'));
    $i->save();


    /* send email */
    
    $o = $i->getOrganization();
    $params= array("i"=>$i, "o"=>$o, "r"=>$i->getRole(), "p"=>$i->getInviter(),"reinvite"=>TRUE);
    $email_params=array(
      "to" => $i->getEmail(),
      "subject" => $i18n->__('Reminder about invitation to %organization% organization.',array("%organization"=>$o)),
      "bodyhtml" => $this->getPartial('invitePrincipal/inviteHtml',$params),
    );

    $this->sendEmail($email_params);

    $this->getUser()->setFlash('notice',$i18n->__('We have resent the invitation.'));
    $this->redirect("show/index?id=".$o->getId());
  }

  public function executeDelete(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $i = Doctrine::getTable('Invitation')->find($request->getParameter('id'));
    if (! $i->getOrganization()->isMy())
    {
      $m=$i18n->__("Insufficent rights");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    $i->delete();
    $this->getUser()->setFlash('notice',$i18n->__('Invitation deleted.'));
    $this->redirect("show/index?id=".$i->getOrganization()->getId());
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

}
