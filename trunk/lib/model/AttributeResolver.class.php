<?php

/**
 * AttributeResolver
 *
 *
 * @author     gyufi@sztaki.hu
 */
class AttributeResolver
{
	public function getEntitlementsForPrincipalToService(Principal $p, Service $s){
		$user = sfContext::getInstance()->getUser();
		$eids=array();

		$rps = Doctrine::getTable('RolePrincipal')->findByPrincipalId($p->getId());
		foreach($rps as $rp){
			$res = Doctrine::getTable('RoleEntitlement')->findByRoleId($rp->getRoleId());
			foreach($res as $re){
				$eids[]=$re->getEntitlementId();
			}
		}
		$ueids = array_unique($eids);
		foreach($ueids as $ueid){
			$e = Doctrine::getTable('Entitlement')->find($ueid);
			// $tmp .= $e->getName()." ".$e->getService()." ".$s->getName()."<br>";
			if ($s->isValidated()){
				if ($e->getServiceId()==$s->getId())
					$es[] = $e;
			}
		}
		if (isset($es)){
			return $es;
		}
		else{
			//var_dump(array($tmp));exit;
			return NULL;
		}
	}

	public function getUrisForPrincipalToService(Principal $p, Service $s){
		if (!$s->isValidated())
			return NULL;
		$es = $this->getEntitlementsForPrincipalToService($p,$s);
		if ($es){
			foreach($es as $e){
				$uris[]=$e->getUri();
			}
			return $uris;
		}
		return NULL;
	}

	public function getUrisForEppnToSpid($eppn,$spid){
		$p = Doctrine::getTable('Principal')->findOneByFedid($eppn);
		if (! $p instanceof Principal){
			throw new sfException("There is no principal such ".$eppn."!");
		}
		$ss = Doctrine::getTable('Service')->findByEntityId($spid);

		foreach ($ss as $s){
			if (! $s instanceof Service){
				throw new sfException("There is no Service such ".$spid."!");
			}
			if (! $s->isValidated()){
				$message = 'The owner of Service '.$spid.' is not valid yet.';
				sfContext::getInstance()->getLogger()->info($message);
				continue;
			}
			$es = $this->getEntitlementsForPrincipalToService($p,$s);
			$uris = array();
			if ($es){
				foreach($es as $e){
					array_push($uris,$e->getUri());
				}
			}
		}
		return $uris;
	}
}
?>