Graduados Server

Herramientas
git
docker
postman
dry

1 - Clonar el proyecto
 - git clone https://gitlab.com/renerecalde/oferta.git
 - git checkout develop
 
2 - Levantar proyecto (docker-compose)
 - make run (si falla , es pq ya existen los contenedores, borrarlos)
 - make prepare (composer install para instalar dependencias)

3 - Ingreso a la instancia de php (no estoy seguro el orden)
 - make ssh-be para ingresar a la instancia
 - sf c:c (borrar cache)
 - sf doctrine:schema:create (crear la db manualmente)
 - sf assets:install  (generar assets)
 
4 - Generar licencias para JWT
 - make generate-ssh-keys

4 - Ir http://localhost:250/api/docs






