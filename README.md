# Sistema de Biblioteca

Sistema completo para gestão de biblioteca, desenvolvido em Laravel.

## Sobre o Sistema

Este sistema foi projetado para gerenciar todas as operações de uma biblioteca, desde o cadastro de usuários até o controle de empréstimos, reservas, doações e multas. Ele atende tanto usuários comuns quanto administradores, com regras de negócio típicas de bibliotecas reais.

### Principais Módulos e Funcionalidades

- **Gestão de Usuários:** Cadastro, autenticação, edição e controle de permissões (usuário comum ou administrador). Cada usuário possui limite de empréstimos, status ativo/inativo e dados completos (nome, CPF, endereço, etc).
- **Catálogo de Livros:** Cadastro detalhado de livros (título, autor, ISBN, editora, ano, gênero, idioma, estado, localização, quantidade, preço, capa). Livros podem pertencer a múltiplas categorias.
- **Categorias de Livros:** Organização dos livros em categorias, com cor e ícone para facilitar a navegação.
- **Empréstimos:** Solicitação, aprovação, renovação (até 2x), controle de devolução, cálculo automático de multas por atraso, histórico de empréstimos e limite de 3 livros por usuário.
- **Reservas:** Usuários podem reservar livros indisponíveis. Reservas expiram em 3 dias após notificação.
- **Doações:** Registro de doações de livros, tanto de usuários cadastrados quanto de doadores externos. Admin pode aceitar, rejeitar ou processar doações.
- **Administração:** CRUD completo de usuários, livros, categorias, empréstimos e doações. Aprovação/rejeição de solicitações, controle de devoluções, multas e relatórios.
- **Relatórios:** Geração de relatórios de empréstimos, multas, reservas e doações para acompanhamento da biblioteca.

### Regras de Negócio

- Cada usuário pode ter no máximo 3 livros emprestados simultaneamente.
- Prazo padrão de empréstimo: 14 dias (configurável).
- Máximo de 2 renovações por empréstimo.
- Multas automáticas por atraso na devolução.
- Reservas expiram em 3 dias após notificação.
- Controle automático de disponibilidade dos livros.

### Tecnologias Utilizadas

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, Tailwind CSS, Vite
- **Banco de Dados:** SQLite (padrão, mas pode ser adaptado)
- **Testes:** Pest, PHPUnit

### Fluxo Básico de Uso

1. Usuário se cadastra e faz login.
2. Busca livros no catálogo, filtra por categoria, autor ou título.
3. Solicita empréstimo de um livro disponível ou faz reserva se estiver indisponível.
4. Admin aprova/rejeita empréstimos e controla devoluções.
5. Usuário pode renovar empréstimos, doar livros e consultar seu histórico.
6. Admin acompanha relatórios, controla multas e gerencia todo o acervo.

## Requisitos

- PHP >= 8.1
- Composer
- Node.js e npm
- mysql (ou postgresql ou qualquer outro banco relacional usado no php)

## Instalação

1. **Clone o repositório:**
   ```bash
   git clone <url-do-repositorio>
   cd biblioteca
   ```

2. **Instale as dependências PHP:**
   ```bash
   composer install
   ```

3. **Instale as dependências JavaScript:**
   ```bash
   npm install
   ```

4. **Copie o arquivo de ambiente:**
   ```bash
   cp .env.example .env
   ```
   Configure as variáveis de ambiente conforme necessário (principalmente DB_CONNECTION, DB_DATABASE, etc).

5. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```

6. **Execute as migrations:**
   ```bash
   php artisan migrate
   ```

7. **(Opcional) Popule o banco com dados iniciais:**
   ```bash
   php artisan db:seed
   ```

8. **Compile os assets:**
   ```bash
   npm run build
   ```

9. **Inicie o servidor de desenvolvimento:**
   ```bash
   php artisan serve
   ```
   O sistema estará disponível em http://localhost:8000

## Estrutura do Projeto

- `app/Models` — Modelos Eloquent (Book, User, BookLoan, etc)
- `app/Http/Controllers` — Controllers das funcionalidades
- `database/migrations` — Migrations das tabelas
- `database/seeders` — Seeders para dados iniciais
- `resources/views` — Views Blade (interface)
- `routes/web.php` — Rotas web

## Comandos Úteis

- Executar migrations: `php artisan migrate`
- Executar seeders: `php artisan db:seed`
- Reverter migrations: `php artisan migrate:rollback`
- Status das migrations: `php artisan migrate:status`
- Criar nova migration: `php artisan make:migration create_table_name`
- Criar novo model: `php artisan make:model ModelName`
- Criar controller: `php artisan make:controller ControllerName`

## Funcionalidades

- Cadastro e login de usuários
- Busca, empréstimo, reserva e doação de livros
- Gerenciamento de usuários, livros, categorias, empréstimos e doações (admin)
- Controle de multas e relatórios

Para detalhes completos de regras de negócio e estrutura do banco, consulte o arquivo `SISTEMA_BIBLIOTECA.md`.

---

Projeto baseado em Laravel. Para dúvidas sobre o framework, consulte a [documentação oficial](https://laravel.com/docs).
"# biblioteca" 
