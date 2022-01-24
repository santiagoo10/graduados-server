# Graduados Server
Backend form graduados app.

## Stack
- git
- docker
- postman
- dry

## Entorno Local
1 - Clonar el proyecto
 - git clone  <del> https://gitlab.com/renerecalde/oferta.git  </del>
 - git checkout develop
 
2 - Levantar proyecto (docker-compose)
 - make run (si falla , es pq ya existen los contenedores, borrarlos)
 - make prepare (composer install para instalar dependencias)

3 - Ingreso a la instancia de php (no estoy seguro el orden)
 - make ssh-be para ingresar a la instancia
 - sf c:c (borrar cache)
 - sf doctrine:schema:create (crear la db manualmente)
 - sf doctrine:fixtures:load (correr fixtures)
 - sf assets:install  (generar assets)
 
4 - Generar licencias para JWT
 - make generate-ssh-keys

5 - Ir http://localhost:250/api/docs


## Entorno productivo

### login heroku
santiagoo10@gmail.com
4896257.Hh

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

