

Iniciamos los contenedores
- make run 

Ingresamos al contenedor de php
- make ssh-be

Instalamos docker-compose (lo creamos dentro de la carpeta project pq symfony no te deja crear un proyecto en un directorio que ya contiene archivos)
- composer create-project symfony/skeleton project ^5.1.0

Movemos todo al raiz
- mv project/* .