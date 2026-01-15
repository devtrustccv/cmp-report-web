
# Caso ainda não tiver php instaldo 
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))

# instalar laravael 
composer global require laravel/installer

# generate key
php artisan key:generate


# rodar app
php artisan serve

# install dom pdf 
composer require barryvdh/laravel-dompdf
