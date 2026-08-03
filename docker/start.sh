#!/bin/bash
set -e

php artisan schedule:work &
php artisan serve --host=0.0.0.0 --port=8000 &

# Se qualquer um dos dois processos morrer, termina o container
# (o orquestrador/docker-compose com restart:always trata do reinício de ambos).
wait -n
exit $?
