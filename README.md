#Graduados Server

##Stack
- git
- docker
- postman
- dry

##Entorno Local
1 - Clonar el proyecto
 - git clone https://gitlab.com/renerecalde/oferta.git
 - git checkout develop
 
2 - Levantar proyecto (docker-compose)
 - make run (si falla , es pq ya existen los contenedores, borrarlos)
 - make prepare (composer install para instalar dependencias)

3 - Ingreso a la instancia de php (no estoy seguro el orden)
 - make ssh-be para ingresar a la instancia
 - sf c:c (borrar cache)
 - sf doctrine:database:create (crear la db manualmente)
 - sf doctrine:migrations:migrate (correr las migraciones)
 -  sf doctrine:fixtures:load (correr fixtures)
 
 -- sino funcionan los fixtures , creamos el user santiagoo/123456 manualmente
 
 INSERT INTO `graduados_db`.`user`
 (`id`,`email`,`roles`,`created_at`,`updated_at`,`password`,`username`,`is_active`,`api_token`,id_firebase`,`discr`)
 VALUES
 (1,
 'santiagoo10@gmail.com',
 '[\"ROLE_USER\"]',
 now(),
 now(),
 '$argon2id$v=19$m=65536,t=4,p=1$cndnYmVmcmppQnVObnBqWQ$XiXnD71U8jqasSsZvT/XolzcP2PB6UDc4mAO9A9sv1E',
 'santiagoo',
 true,
 null,
 null,
 'admin');
 
 Borrar y crear todo de nuevo (en caso que lo necesitemos)
 -- sf doctrine:database:drop --force 
 -- sf doctrine:database:create
 -- sf doctrine:migrations:migrate
 
 - sf assets:install  (generar assets)
 
 
4 - Generar licencias para JWT
 - make generate-ssh-keys

5 - Ir http://localhost:250/api/docs


##Entorno productivo

###login heroku
santiagoo10@gmail.com
4896257.Hh

## Database
Host	zj2x67aktl2o6q2n.cbetxkdyhwsb.us-east-1.rds.amazonaws.com	
Username	nztqn1svcy6trc1x	
Password	mhp9h59ec8il1lie	
Port	3306	
Database	dklzphht478zlpr1

- heroku apps:create graduados-api

- Create Orocfile

echo 'web: heroku-php-apache2 public/' > Procfile
git add Procfile
git commit -m "Heroku Procfile"

- Configuración de Symfony para que se ejecute en el entorno prod
heroku config:set APP_ENV=prod

- Acceso instancia de heroku
ps:exec
 - php bin/console cache:clear
 
 Generar las credenciales dentro de la instancia
  mkdir -p config/jwt
  openssl genrsa -passout pass:b4a42db9c2995ae84a9e1fe8aae5b95f -out config/jwt/private.pem -aes256 4096
  openssl rsa -pubout -passin pass:b4a42db9c2995ae84a9e1fe8aae5b95f -in config/jwt/private.pem -out config/jwt/public.pem

- Logs
heroku logs --tail

