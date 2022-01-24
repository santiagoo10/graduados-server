# Graduados Server
Backend for graduados app.

## Stack
- git
- docker compose
- php storm
- postman (opcional)

## Entorno Local

####  1 - Clonar el proyecto
 - git clone <del> https://gitlab.com/renerecalde/oferta.git </del>
 - git checkout develop
 
####  2 - Levantar proyecto (docker-compose)
 - make run (si falla , es pq ya existen los contenedores, borrarlos)
 - make prepare (composer install para instalar dependencias)

####  3 - Ingreso a la instancia de php (no estoy seguro el orden)

- chequear conexion database
.env -> DATABASE_URL=mysql://root:root@graduates-server-db:3306/graduados_db?serverVersion=8.0
(database local o heroku remote)

 - make ssh-be para ingresar a la instancia
 - sf c:c (borrar cache)
 - sf doctrine:database:create (crear la db manualmente)
 - sf doctrine:migrations:migrate (correr las migraciones)
 - sf doctrine:fixtures:load (correr fixtures)
 
 -- sino funcionan los fixtures , creamos el user santiagoo/123456 manualmente
 
 INSERT INTO `graduados_db`.`user`
 (`id`,`email`,`roles`,`created_at`,`updated_at`,`password`,`username`,`is_active`,`api_token`,id_firebase`,`discr`)
 VALUES
 (1,'santiagoo10@gmail.com','[\"ROLE_ADMIN\"]',now(),now(),'$argon2id$v=19$m=65536,t=4,p=1$cndnYmVmcmppQnVObnBqWQ$XiXnD71U8jqasSsZvT/XolzcP2PB6UDc4mAO9A9sv1E','santiagoo',true,null,null,'admin');
 
 Borrar y crear todo de nuevo (en caso que lo necesitemos)
 -- sf doctrine:database:drop --force 
 -- sf doctrine:database:create
 -- sf doctrine:migrations:migrate
 
 - sf assets:install  (generar assets)
 
####  4 - Generar licencias para JWT
 - make generate-ssh-keys

####  5 - Ir http://localhost:250/api/docs

##Entorno productivo

###Login heroku console
https://dashboard.heroku.com/apps/graduados-api
santiagoo10@gmail.com - 4896257.Hh

### Credentials Database
- Host:	zj2x67aktl2o6q2n.cbetxkdyhwsb.us-east-1.rds.amazonaws.com	
- Username:	nztqn1svcy6trc1x	
- Password:	mhp9h59ec8il1lie	
- Port:	3306	
- Database:	dklzphht478zlpr1

### Create app
- heroku apps:create graduados-api

### Create Orocfile
- echo 'web: heroku-php-apache2 public/' > Procfile
- git add Procfile
- git commit -m "Heroku Procfile"

### Acceso instancia de heroku
ps:exec
 - php bin/console cache:clear
 
### View Logs
- heroku logs --tail

### Configuración de Symfony para que se ejecute en el entorno prod
heroku config:set APP_ENV=prod
