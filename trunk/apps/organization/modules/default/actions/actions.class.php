<?php

/**
 * default actions.
 *
 * @package    sf_sandbox
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if (!$request->getParameter('sf_culture'))
    { 
      $ssaml = new SimpleSAML_Auth_Simple('default-sp');
      $attributes = $ssaml->getAttributes();
      
      if ($this->getUser()->isFirstRequest())
    {
      if (array_key_exists('preferredLanguage', $attributes)) 
      {
        $culture = $attributes['preferredLanguage'];
        if ($culture != 'hu' && $culture != 'en')
        {
          $culture = $request->getPreferredCulture(array('en', 'hu'));
        }
      } else {
        $culture = $request->getPreferredCulture(array('en', 'hu'));
      }
      $this->getUser()->setCulture($culture);
      $this->getUser()->isFirstRequest(false);
    }
    else
    {
      $culture = $this->getUser()->getCulture();
    }
     
    $this->redirect('localized_homepage');
    }
    
    $p = Doctrine::getTable('Principal')->findOneByFedid($this->getUser()->getUsername());
    
    if ($p){
      $oos = $p->getOrganization();
      $ros = $p->getRelatedOrganizations(TRUE);
    }
    /* A felhasználó most van itt először. Berakjuk a principal-ba. */
    else
    {
      $p = new Principal();
      $p->setFedid($this->getUser()->getUsername());
      $p->save();
    }

    $this->oos=$oos;
    $this->ros=$ros;



  }

  
  public function executeProcessNewOrgForm(sfWebRequest $request)
  {
    $f = $request->getParameter("organization");
    $p = Doctrine::getTable('Principal')->findOneByFedid($this->getUser()->getUsername());
 
    $o = new Organization();
    $o->setName($f["name"]);
    $o->setDescription($f["description"]);
    $o->setCreatedAt(date('Y-m-d H:i:s'));
    $o->save();

    $op = new OrganizationPrincipal();
    $op->setOrganization($o);
    $op->setPrincipal($p);
    $op->save();

    $i = new Invitation();
    $i->setEmail($p->getEmail());
    $i->setOrganization($o);
    $i->setUuid('1');
    $i->setCreatedAt(date('Y-m-d H:i:s'));
    $i->setAcceptAt(date('Y-m-d H:i:s'));
    $i->setCounter(1);
    $i->setInviter($p);
    $i->setPrincipal($p);
    $i->setStatus("accepted");

    $i->save();

    $r = new Role();
    $r->setName($f["role_name"]);
    $r->setOrganization($o);
    $r->setShoworder(0);
    $r->save();

    $o->setDefaultRoleId($r->getId());
    $o->save();

    $this->redirect("show/index?id=".$o->getId());
  }

  public function executeProcessDeleteOrgForm(sfWebRequest $request)
  {
    $this->forward404Unless($request->getParameter('confirm') == 'Igen'); 
    $o = Doctrine::getTable('Organization')->find($request->getParameter("id"));
    $this->forward404Unless($o->isMy()); 
    $o->delete();

    $this->redirect("default/index");
  }

  public function executeError()
  {
  }

  public function executeLoggedout()
  {
  }
}
