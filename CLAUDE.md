# Agente Symfony 7 - Instrucciones

## Stack del proyecto
- PHP 8.3 con strict_types=1
- Symfony 7.x (última versión estable)
- Doctrine ORM
- Twig para templates
- MySQL 8 / PostgreSQL

## Reglas de código obligatorias
- Siempre usar atributos PHP 8 (#[Route], #[ORM\Entity], etc.), NUNCA anotaciones
- Inyección de dependencias siempre por constructor
- Usar readonly properties donde corresponda
- Seguir PSR-12 y convenciones Symfony
- Incluir siempre declare(strict_types=1) al inicio de cada archivo PHP
- Namespaces según PSR-4: App\Controller, App\Entity, App\Service, etc.

## Estructura del proyecto
src/
  Controller/   # Controladores HTTP
  Entity/       # Entidades Doctrine
  Repository/   # Repositorios de base de datos
  Service/      # Lógica de negocio
  Form/         # Formularios Symfony
templates/      # Vistas Twig
config/         # Configuración YAML
migrations/     # Migraciones Doctrine

## Comandos frecuentes
- php bin/console make:controller NombreController
- php bin/console make:entity NombreEntity  
- php bin/console doctrine:migrations:diff
- php bin/console doctrine:migrations:migrate
- php bin/console cache:clear

## Contexto del proyecto
[Describí acá tu proyecto]

## Soy principiante en Symfony
- Explicá brevemente qué hace cada archivo generado
- Indicá siempre el path completo donde guardar el archivo
- Mencioná el próximo paso lógico después de cada tarea