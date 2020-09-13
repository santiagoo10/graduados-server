

Iniciamos los contenedores
- make run 

Ingresamos al contenedor de php
- make ssh-be

Instalamos docker-compose (lo creamos dentro de la carpeta project pq symfony no te deja crear un proyecto en un directorio que ya contiene archivos)
- composer create-project symfony/skeleton project ^5.1.0

Movemos todo al raiz
- mv project/* .

Configurar xdebug

Instalar librerias
- composer require monolog doctrine phpunit
- composer require --dev browser-kit maker
- composer require api

Configurar pahts de api platform

- modificamos config/packages/api_platform.yaml
 - '%kernel.project_dir%/config/api_platform/resources'

- creamos los directorios api_platform/
       filter resources serialization
  
  configurar resources de api platform
  
  api_platform:
      mapping:
          paths:
              - '%kernel.project_dir%/config/api_platform/resources'
      patch_formats:
          json: ['application/merge-patch+json']
      swagger:
          versions: [3]
          api_keys:
              name: Authorization
              type: header
          title: Graduados API Platform
          version: 1.0
          show_webby: false     
       
  configurar serializador (packages/framewor.yaml)
  -     serializer:
            mapping:
                path:
                    - '%kernel.project_dir%/config/api_platform/serialization'  
                    
instalar libs para token y uid (para la parte de usuarios)
- composer require symfony/security-core symfony/uid
                
creamos los mapeos del orm dentro de config/orm/mapping

- siempre que se haga un update se ejecuta markAsUpdated
        <lifecycle-callbacks>
            <lifecycle-callback type="preUpdate" method="markAsUpdated"/>
        </lifecycle-callbacks>
        
        - en package/doctrine.yaml congiruramos el tipo de mapping anotation/archivo de mapping
              
