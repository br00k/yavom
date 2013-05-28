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
       ->from('ServiceInvitation i')
       ->where('i.principal_id = ?', $p->getId())
       ->andWhere('i.status = ?', 'pending');
 
    $qais = Doctrine_Query::create()
       ->from('ServiceInvitation i')
       ->where('i.principal_id = ?', $p->getId())
       ->andWhere('i.status = ?', 'accepted');

    $this->pis = $qpis->execute();
    $this->ais = $qais->execute();

  }

  public function executeInviteForm(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $s = Doctrine::getTable('Service')->find($request->getParameter('s_id'));
    if (! $s)
    {
      $m=$i18n->__("Couldn't find the requested service: id=%id%",array("%id%"=>$request->getParameter('s_id')));
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    if (! $s->isMy())
    {
      $m=$i18n->__('Only managers can invite new members.');
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
        $this->form = new ServiceInvitePrincipalForm(
       array(
           's_id'=>$s->getId()
           )
       );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $form = new ServiceInvitePrincipalForm();
    $a = $request->getParameter($form->getName());
    $sid = $a['s_id'];
    $form->bind($request->getParameter('invite'));
    if (! $form->isValid()) {
      $this->getUser()->setFlash('notice',$i18n->__('Could not send the invitation, please check the e-mail address and try again!'));
      $this->redirect("show/index?id=".$sid);
    }
    $emails = $form->getValue('email'); 
    $s_id  = $form->getValue('s_id');
    $m = $form->getValue('message');
    $s = Doctrine::getTable('Service')->find($s_id);
    $p = $this->getUser()->getPrincipal();

    /*TODO ugye nem szerepel már az email cím?*/
    
    foreach ($emails as $email)
    {
      $uuid = uniqid();
 
      $i = new ServiceInvitation();
      $i->setEmail($email);
      $i->setServiceId($s);
      $i->setUuid($uuid);
      $i->setCreatedAt(date('Y-m-d H:i:s'));
      $i->setCounter(1);
      $i->setInviter($p);
      $i->setStatus('pending');
      $i->save();

      
      /* Send email */
      $params= array("i"=>$i, "m"=>$m, "s"=>$s, "p"=>$p, "reinvite"=>FALSE);
      $email_params=array(
        "to" => $i->getEmail(),
        "subject" => $i18n->__('Invitation to %service% service',array("%service%"=>$s)),
        "bodyhtml" => $this->getPartial('invitePrincipal/inviteHtml',$params),
      );
  
      $this->sendEmail($email_params);
    }

    $this->getUser()->setFlash('notice',$i18n->__('The invitation has been sent.'));
    $this->redirect("show/index?id=".$s->getId());
  }

  public function executeResolve(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $i = Doctrine::getTable('ServiceInvitation')->findOneByUuid($request->getParameter('uuid'));

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
    $s = $i->getService();
    foreach ($i->getPrincipal() as $prin)
    {
      if ($prin and $prin->getId() == $this->getUser()->getPrincipalId())
      {
        $i->delete();
        $m=$i18n->__('You are already a member of this service. The invitation has lost its purpose, so we have deleted it.');
        $this->getUser()->setFlash('notice',$m);
        $this->redirect("show/index?id=".$s->getId());
      }
    }

    $p_id = $this->getUser()->getPrincipalId();
    $i->setAcceptAt(date('Y-m-d H:i:s'));
    $i->setStatus('accepted');
    $i->setPrincipalId($p_id);
    $i->save();
    
    $sp = new ServicePrincipal();
    $sp->setPrincipalId($p_id);
    $sp->setServiceId($s->getId());
    $sp->save();
    

    /* Send email */
    $params= array("s"=>$s, "p"=>$p);
    /* szervezők email címei */
    $to = $s->getManagersEmailArray();
    $email_params=array(
      "to" => $to,
      "subject" => $i18n->__('%lname% has accepted the invitation to %service%', array("%lname"=>$p->getUser()->getLastName(),"%service%"=>$s)),
      "bodyhtml" => $this->getPartial('invitePrincipal/acceptHtml',$params),
    );
    $this->sendEmail($email_params);

    $this->getUser()->setFlash('notice',$i18n->__('You have been successfully added to %service% service.', array("%service%"=>$s)));
    $this->redirect("show/index?id=".$s->getId());
  }

  public function executeReinvite(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $i = Doctrine::getTable('ServiceInvitation')->find($request->getParameter('id'));
    if (! $i->getService()->isMy())
    {
      $m=$i18n->__("Insufficent rights");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }

    $i->setCounter($i->getCounter()+1);
    $i->setLastReinviteAt(date('Y-m-d H:i:s'));
    $i->save();


    /* send email */
    
    $s = $i->getService();
    $params= array("i"=>$i, "s"=>$s, "p"=>$i->getInviter(),"reinvite"=>TRUE);
    $email_params=array(
      "to" => $i->getEmail(),
      "subject" => $i18n->__('Reminder about invitation to %service% service.',array("%service%"=>$s)),
      "bodyhtml" => $this->getPartial('invitePrincipal/inviteHtml',$params),
    );

    $this->sendEmail($email_params);

    $this->getUser()->setFlash('notice',$i18n->__('We have resent the invitation.'));
    $this->redirect("show/index?id=".$s->getId());
  }

  public function executeDelete(sfWebRequest $request)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $i = Doctrine::getTable('ServiceInvitation')->find($request->getParameter('id'));
    $s = $i->getService();
    if (! $i->getService()->isMy())
    {
      $m=$i18n->__("Insufficent rights");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
    $invited_email = $i->getEmail();
    /*TODO kell ez?
    if ($i->getStatus() == "accepted") {
    $sp = Doctrine_Query::create()->from('ServicePrincipal sp')
      ->where('sp.principal_id=?',$i->getPrincipalId())->andWhere('sp.service_id=?',$i->getServiceId())
      ->execute();
    $sp->delete();
    */
    
    $i->delete();
    
    
    $to = $s->getManagersEmailArray();
    $to[$invited_email] = "";
    $params = array();
    $params['subject'] = $i18n->__("Invitation to service %service% deleted", array("%service%"=>$s));
    $params['bodyhtml'] = $this->getPartial('invitePrincipal/deletedHtml',array("s"=>$s, "email"=>$invited_email));
    $this->sendEmail($params);
    
    $this->getUser()->setFlash('notice',$i18n->__('Invitation deleted.'));
    $this->redirect("show/index?id=".$i->getService()->getId());
    
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
