<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
require_once dirname(__FILE__).'/../lib/vendor/simplesamlphp/lib/_autoload.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  // some mails don't have a specific person as the sender, there we'll use this one
  public static $mail_from = array("vo@sztaki.hu"=>"Virtual Organizations"); // "from@doma.in"=>"Display Name"
  // tag in the mail subjects
  public static $mail_tag = "[VO] "; // don't forget the space afterwards!
  
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfSAMLPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('sfDoctrineGraphvizPlugin');
    
   
  }
}
