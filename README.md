# Gerenciador de Produtos - Teste T�cnico Laravel

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Docker](https://img.shields.io/badge/Docker-28.3.2%2B-2496ED?style=for-the-badge&logo=docker)
![MySQL](https://img.shields.io/badge/MySQL-9.4.0-4479A1?style=for-the-badge&logo=mysql)
![PHPUnit](https://img.shields.io/badge/Tests-PHPUnit-8892BF?style=for-the-badge)

## ? Descri��o do Projeto

Este projeto � uma aplica��o web completa para o gerenciamento de produtos, desenvolvida como solu��o para um teste t�cnico de Desenvolvedor PHP. A aplica��o foi constru�da utilizando **Laravel 12** e encapsulada em um ambiente **Docker**, seguindo as melhores pr�ticas de desenvolvimento, como princ�pios **SOLID**, arquitetura limpa e uma su�te de **testes automatizados**.

A solu��o oferece duas interfaces principais:
1.  Uma **Interface Web (Full-Stack)** com autentica��o e um CRUD completo para gerenciar produtos.
2.  Uma **API RESTful** protegida por token (Laravel Sanctum) que exp�e os mesmos endpoints de CRUD para integra��o com outros sistemas.

## ? �ndice

- [Tecnologias Utilizadas](#-tecnologias-utilizadas)
- [Funcionalidades Implementadas](#-funcionalidades-implementadas)
- [Como Executar a Aplica��o](#-como-executar-a-aplica��o)
- [Como Executar os Testes](#-como-executar-os-testes)
- [Documenta��o da API](#-documenta��o-da-api)
- [Screenshots (Exemplos)](#-screenshots-exemplos)
- [Licen�a](#-licen�a)

## ? Tecnologias Utilizadas

- **Backend:** PHP 8.3, Laravel 12
- **Frontend:** Blade, Bootstrap 5
- **Banco de Dados:** MySQL 9.4.0
- **Servidores e Cont�ineres:** Docker, Docker Compose
- **Autentica��o:** Laravel Breeze (Web), Laravel Sanctum (API)
- **Testes:** PHPUnit

## ? Funcionalidades Implementadas

- [x] **Ambiente Docker:** Configura��o com Docker Compose para os servi�os de `app` (PHP-FPM) e `db` (MySQL).
- [x] **Sistema de Autentica��o:**
    - [x] Autentica��o baseada em sess�o para a interface web (Laravel Breeze).
    - [x] Autentica��o baseada em token para a API (Laravel Sanctum).
- [x] **CRUD Completo via Interface Web:**
    - [x] Tela de listagem de produtos com pagina��o.
    - [x] Formul�rios para criar e editar produtos.
    - [x] Tela para visualiza��o de detalhes de um produto.
    - [x] Funcionalidade para excluir produtos.
- [x] **API RESTful Protegida:**
    - [x] Endpoints para todas as opera��es CRUD (`index`, `store`, `show`, `update`, `destroy`).
    - [x] Rotas protegidas exigindo um token de autentica��o `Bearer`.
- [x] **Valida��es e Tratamento de Erros:**
    - [x] Valida��es robustas no backend utilizando `Form Requests`.
    - [x] Feedback visual de erros nos formul�rios web.
    - [x] Respostas de erro padronizadas em JSON para a API.
- [x] **Testes Automatizados:**
    - [x] **Testes Unit�rios:** Para validar as restri��es e o comportamento do Model `Produto`.
    - [x] **Testes de Feature:** Cobertura completa para todos os controllers (Web e API), simulando requisi��es HTTP e validando respostas, status e intera��es com o banco de dados.

## ?? Como Executar a Aplica��o

### Pr�-requisitos
- Git
- Docker
- Docker Compose

### Passos para Instala��o

1.  **Clone o reposit�rio:**
    ```bash
    git clone [https://github.com/GuilhermeWatanabe/laravel-product-management.git](https://github.com/GuilhermeWatanabe/laravel-product-management.git)
    cd laravel-product-management
    ```

2.  **Copie e Configure o arquivo de ambiente:**
    Primeiro, copie o arquivo de exemplo.
    ```bash
    cp .env.example .env
    ```
    **Importante: Edite o arquivo `.env`!** Para que a aplica��o no cont�iner Docker consiga se comunicar com o cont�iner do banco de dados, voc� precisa ajustar as vari�veis de conex�o. Garanta que as seguintes vari�veis estejam configuradas da seguinte forma:

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=user
    DB_PASSWORD=password
    ```
    > **Nota:** O valor `DB_HOST=db` � essencial. `db` � o nome do servi�o do banco de dados definido no arquivo `docker-compose.yml`, permitindo que os cont�ineres se comuniquem pela rede interna do Docker.

3.  **Suba os cont�ineres do Docker:**
    Este comando ir� construir as imagens e iniciar os servi�os em background.
    ```bash
    docker-compose up -d --build
    ```

4.  **Instale as depend�ncias do Composer:**
    ```bash
    docker-compose exec app composer install
    ```

5.  **Gere a chave da aplica��o:**
    ```bash
    docker-compose exec app php artisan key:generate
    ```

6.  **Execute as migrations e popule o banco de dados:**
    Este comando ir� criar as tabelas e popular a tabela de produtos com dados de exemplo (o usu�rio para acesso ainda precisar� ser criado na tela de registro do sistema).
    ```bash
    docker-compose exec app php artisan migrate --seed
    ```
    
### Acesso � Aplica��o

? Pronto! A aplica��o j� est� rodando.

- **Interface Web:** [http://localhost:8000](http://localhost:8000)
- **Base da API:** `http://localhost:8000/api/`

## ? Como Executar os Testes

A aplica��o possui uma su�te completa de testes unit�rios e de feature para garantir a qualidade e a integridade do c�digo.

### ?? AVISO IMPORTANTE: Configura��o do Banco de Dados de Testes

> Este projeto est� configurado para executar os testes no **mesmo banco de dados** utilizado para o desenvolvimento (`DB_HOST=db`, `DB_DATABASE=laravel_db`).
>
> Isso significa que ao rodar a su�te de testes, o trait `RefreshDatabase` do Laravel **IR� APAGAR TODOS OS DADOS** que existem atualmente nas suas tabelas (produtos, usu�rios, etc.) para garantir um ambiente limpo para cada teste.
>
> **Proceda com cuidado.** Ap�s a execu��o dos testes, seus dados de desenvolvimento ser�o perdidos. Ser� necess�rio repopular o banco de dados para continuar usando a aplica��o normalmente.

### 1. Configura��o do Ambiente de Teste

Antes de rodar os testes pela primeira vez, voc� precisa criar o arquivo de ambiente de testes a partir do exemplo fornecido.

```bash
cp .env.testing.example .env.testing
```

**Importante: Edite o arquivo `.env.testing`!** Para que a aplica��o no cont�iner Docker consiga se comunicar com o cont�iner do banco de dados, voc� precisa ajustar as vari�veis de conex�o. Garanta que as seguintes vari�veis estejam configuradas da seguinte forma:

```ini
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=user
DB_PASSWORD=password
```
> **Nota:** O valor `DB_HOST=db` � essencial. `db` � o nome do servi�o do banco de dados definido no arquivo `docker-compose.yml`, permitindo que os cont�ineres se comuniquem pela rede interna do Docker.

### 2. Executando a Su�te de Testes

Para rodar todos os testes (Unit�rios e de Feature), execute o seguinte comando no seu terminal:

```bash
docker-compose exec app php artisan test
```

### 3. Restaurando os Dados de Desenvolvimento

Como mencionado no aviso, os testes apagaram seus dados. Para repopular o banco com os dados de exemplo novamente (os `seeders`), execute o seguinte comando:

```bash
docker-compose exec app php artisan db:seed
```

Ap�s este comando, sua aplica��o web voltar� a ter os dados iniciais para uso, precisando apenas cadastrar o usu�rio novamente para poder acessar o sistema.

## ? Documenta��o da API

> **?? Importante: Header Obrigat�rio**
>
> Todas as requisi��es feitas para esta API **devem** incluir o header `Accept` com o valor `application/json`.
>
> `Accept: application/json`
>
> Se este header n�o for enviado, a requisi��o poder� ser interpretada como vinda de uma aplica��o web (full stack). Como resultado, em caso de erros (especialmente falhas de valida��o), o Laravel retornar� uma p�gina HTML de redirecionamento em vez de uma resposta JSON estruturada, o que quebrar� a integra��o com a sua aplica��o.

### Autentica��o
Para acessar os endpoints protegidos, primeiro obtenha um token via `/api/login` e envie-o no header `Authorization` de suas requisi��es subsequentes.

`Authorization: Bearer <SEU_TOKEN>`

---

### Endpoints P�blicos

| M�todo | Endpoint         | Descri��o                    | Exemplo de Body (Payload)                               |
| :----- | :--------------- | :--------------------------- | :------------------------------------------------------ |
| `POST` | `/api/register`  | Registra um novo usu�rio.    | `{ "name": "Seu Nome", "email": "email@teste.com", "password": "password", "password_confirmation": "password" }` |
| `POST` | `/api/login`     | Autentica um usu�rio e retorna um token. | `{ "email": "email@teste.com", "password": "password" }` |

---

### Endpoints Protegidos (Produtos)

| M�todo   | Endpoint             | Descri��o                        | Exemplo de Body (Payload)                                                |
| :------- |:---------------------| :------------------------------- |:-------------------------------------------------------------------------|
| `POST`   | `/api/logout`        | Invalida o token de autentica��o. | -                                                                        |
| `GET`    | `/api/products`      | Lista todos os produtos (paginado). | -                                                                        |
| `POST`   | `/api/products`      | Cria um novo produto.            | `{ "name": "Produto Novo", "price": 19.99, "stock_quantity": 100 }`      |
| `GET`    | `/api/products/{id}` | Exibe os detalhes de um produto. | -                                                                        |
| `PUT`    | `/api/products/{id}` | Atualiza um produto existente.   | `{ "name": "Produto Atualizado", "price": 25.50, "stock_quantity": 53 }` |
| `DELETE` | `/api/products/{id}` | Exclui um produto.               | -                                                                        |

## ?? Screenshots das Principais Telas

### Tela de Login
![img_1.png](img_1.png)

### Tela de Login com Credenciais Inv�lidas.
![img_2.png](img_2.png)

### Tela de Produtos
![img_3.png](img_3.png)

### Demonstra��o do CRUD
![Demonstra��o do CRUD](.github/assets/CRUD.gif)

## ?? Screenshots das Rotas da API

### Rota de Registro de Usu�rio
![img_4.png](img_4.png)

### Rota de Login
![img_5.png](img_5.png)

### Rota de Listagem de Produtos
![img_6.png](img_6.png)

### Rota de Cadastrar Produto
![img_7.png](img_7.png)

### Rota de Buscar Produto
![img_8.png](img_8.png)

### Rota de Atualizar Produto
![img_9.png](img_9.png)

### Rota de Deletar Produto
![img_10.png](img_10.png)