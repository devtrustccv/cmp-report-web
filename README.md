# CMP Web Report

Sistema de geração de relatórios e documentos oficiais desenvolvido com Laravel.

---

# Tecnologias Utilizadas

- PHP 8.2+
- Laravel 11
- Blade Template Engine
- DomPDF
- QRCode
- HTML5
- CSS3

---

# Requisitos do Sistema

Antes de iniciar o projeto, certifique-se de possuir:

| Tecnologia | Versão |
|---|---|
| PHP | >= 8.2 |
| Composer | >= 2 |
| Laravel | 11 |
| Git | Última versão |

---

# Download das Ferramentas

## PHP

Download oficial:

- https://windows.php.net/download/
- https://www.php.net/downloads.php

Verificar instalação:

```bash
php -v
```

---

## Composer

Download oficial:

- https://getcomposer.org/download/

Verificar instalação:

```bash
composer -V
```

---

## Laravel

Site oficial:

- https://laravel.com/

Documentação oficial:

- https://laravel.com/docs

Instalação global do Laravel:

```bash
composer global require laravel/installer
```

Verificar instalação:

```bash
laravel -V
```

---

# Clonar Projeto

```bash
git clone <url-do-repositorio>
```

Entrar na pasta:

```bash
cd  cmp-web-report
```

---

# Instalação do Projeto

## Instalar dependências PHP

```bash
composer install
```

---

## Criar arquivo .env

Windows:

```bash
copy .env.example .env
```

Linux/Mac:

```bash
cp .env.example .env
```

---

## Gerar chave da aplicação

```bash
php artisan key:generate
```

---

## Limpar cache

```bash
php artisan optimize:clear
```

---

# Executar Projeto

```bash
php artisan serve
```

A aplicação ficará disponível em:

```txt
http://127.0.0.1:8000
```

---

# Estrutura do Projeto

```txt
app/
├── Enums/
├── Helpers/
├── Http/
│   └── Controllers/
├── Services/

public/
└── img/

resources/
└── views/
    └──
---

## Estrutura de Serviços

```txt
Laravel
│
├── ApiService
│   └── Consome API Spring Boot
│
├── ReportService
│   └── Gera PDFs
│
├── Blade Templates
│   └── Layouts e componentes
│
└── QRCodeHelper
    └── Geração de QR Codes
```


---

# Autor

Devtrust/Janir Alves

---

# Licença

Projeto interno.