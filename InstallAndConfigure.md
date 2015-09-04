# Yet Another Virtual Organization Manager #

The software is a central group and entitlement management system with SAML protocol for AAI federations.

![https://docs.google.com/drawings/d/1AkAW_capnCV32AQO84NoYh7J2_tqkpXwJaPVYChxpjk/pub?w=960&amp;h=720.png](https://docs.google.com/drawings/d/1AkAW_capnCV32AQO84NoYh7J2_tqkpXwJaPVYChxpjk/pub?w=960&amp;h=720.png)

## Install ##

You have to have a SAML federation with working `IdPs` SPs, and metadata management.

### Install and configure YAVOM software ###

Get the YAVOM source and copy to your webserver directory.

Enable cache directory write access to the webserver user.
```
chown www-data cache
```

Get simpleSAMLphp and install to `lib/vendor/simplesamlphp` directory.

```
cd lib/vendor
wget https://simplesamlphp.googlecode.com/files/simplesamlphp-1.10.0.tar.gz
tar -xzvf simplesamlphp-1.10.0.tar.gz
rm simplesamlphp-1.10.0.tar.gz
mv simplesamlphp-1.10.0 simplesamlphp
cd ../..
```

Configure it as `ServiceProvider` into your federation.

The requiered attributes are: eduPersonPrincipalName, mail.

The suggested attribute is: displayName.

Be sure the authentication source id is _default-sp_.


Install the **[aa](https://code.google.com/p/aa4ssp)** module to simpleSAMLphp instance and configure it. Register YAVOM's `AttributeAuthority` metadata to the federation.


Create the data store and the user access to it, copy _config/databases.yml.source_ to _config/databases.yml_ and edit according the data store.

Create the YAVOM tables into database, get credentials from previous step.

```
mysql -u yavom -pXXXX yavom < data/sql/schema.sql
```

Configure apache.

```
        DocumentRoot /var/www/yavom/web
        DirectoryIndex index.php
        <Directory /var/www/yavom/web>
                AllowOverride All
                Allow from all
        </Directory>

        Alias /simplesaml /var/www/yavom/lib/vendor/simplesamlphp/www
        <Directory /var/www/yavom/lib/vendor/simplesamlphp/www>
                AllowOverride All
                Allow from all
        </Directory>

        Alias /sf /var/www/yavom/lib/vendor/symfony/data/web/sf
        <Directory "/home/user/jobeet/lib/vendor/symfony/data/web/sf">
            AllowOverride All
            Allow from All
        </Directory>
```


### Install and configure simpleSAMLphp '''attributeaggregator''' module for Service Provider to use YAVOM ###

Getting YAVOM's `AttributeAuthority` metadata.

Getting **[attributeaggregator](https://code.google.com/p/attributeaggregator/wiki/InstallAndConfigure)** module into SSP modules.

Register the SP to YAVOM, share the entitlements to a VO.

Testing the given entitlement after a SAML login.

### Install and configure shibboleth Service Provider to use YAVOM ###

Getting YAVOM's `AttributeAuthority` metadata.

Configure `SimpleAggregation` `AttributeResolver` in shibboleth2.xml.

```
....
<AttributeResolver type="Chaining">

       <AttributeResolver type="Query"/>

        <!-- Uses eduPersonPrincipalName from IdP to query, and asks for eduPersonEntitlement. -->
        <AttributeResolver type="SimpleAggregation" attributeId="eppn" format="urn:oasis:names:tc:SAML:2.0:nameid-format:persistent">
               <Entity>https://devyavom.felho.sztaki.hu/ssp</Entity>
               <Attribute Name="urn:oid:1.3.6.1.4.1.5923.1.1.1.7" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri" FriendlyName="eduPersonEntitlement"/>
        </AttributeResolver>
</AttributeResolver>
....
```


Register the SP to YAVOM, share the entitlements to a VO.

Testing the given entitlement after a SAML login.