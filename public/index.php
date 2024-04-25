<?php 

// abrir a sessao
session_start();

// carrega o config
require_once('../config.php');
/* carrega os arquivos das pastas que foram configuradas no auto-load do arquivo composer.json
Ex: todas as classes do projeto que se encontrar na pasta core/classes. */ 
require_once('../vendor/autoload.php');
// carrega o sistema de rotas
require_once('../core/routes.php');