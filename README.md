# RPG Management System

Este é um projeto de gerenciamento de personagens, habilidades, itens e monstros para um RPG. O sistema permite que os usuários gerenciem personagens, suas habilidades, inventários e interajam com monstros. Além disso, oferece uma API para manipulação de dados de personagens e grupos (parties).

## Funcionalidades

### Autenticação
- **Login e Registro**: Sistema de autenticação completo para que os usuários possam se registrar, fazer login e logout.
  - `GET /login`: Exibe o formulário de login.
  - `POST /login`: Realiza o login do usuário.
  - `GET /register`: Exibe o formulário de registro.
  - `POST /register`: Registra um novo usuário.
  - `POST /logout`: Realiza o logout do usuário.

### Personagens
- **CRUD de Personagens**: Criação, leitura, atualização e exclusão de personagens.
  - `GET /characters`: Lista todos os personagens.
  - `POST /characters`: Cria um novo personagem.
  - `GET /characters/{character}`: Exibe detalhes de um personagem específico.
  - `PUT /characters/{character}`: Atualiza um personagem.
  - `DELETE /characters/{character}`: Exclui um personagem.

### Habilidades
- **Gerenciamento de Habilidades**: Adicionar e remover habilidades dos personagens.
  - `POST /characters/{character}/skills/add`: Adiciona uma habilidade a um personagem.
  - `DELETE /characters/{character}/skills/{skill}/remove`: Remove uma habilidade de um personagem.

### Itens e Inventário
- **Gerenciamento de Itens**: Adicionar e remover itens do inventário de um personagem.
  - `POST /inventory/{inventory}/add`: Adiciona um item ao inventário.
  - `DELETE /inventory/{character}/item/{item}`: Remove um item do inventário de um personagem.

### Monstros
- **Listagem e Detalhes de Monstros**: Visualizar uma lista de monstros e os detalhes de um monstro específico.
  - `GET /monsters`: Lista todos os monstros.
  - `GET /monsters/{name}`: Exibe os detalhes de um monstro específico.

### Home
- **Página Inicial**: Exibe a página inicial após o login.
  - `GET /home`: Página inicial protegida, acessível somente para usuários autenticados.

## API

### Personagens (API)
- **CRUD de Personagens via API**: Manipulação de personagens através da API.
  - `GET /api/characters`: Lista todos os personagens.
  - `POST /api/characters`: Cria um novo personagem.
  - `GET /api/characters/{character}`: Exibe detalhes de um personagem específico.
  - `PUT /api/characters/{character}`: Atualiza um personagem.
  - `DELETE /api/characters/{character}`: Exclui um personagem.

### Grupos (Parties)
- **Gerenciamento de Grupos via API**: Manipulação de grupos de personagens.
  - `GET /api/parties`: Lista todos os grupos.
  - `POST /api/parties`: Cria um novo grupo.
  - `PUT /api/parties/{party}`: Atualiza um grupo.
  - `DELETE /api/parties/{party}`: Exclui um grupo.
  - `POST /api/parties/reorder`: Reordena os personagens dentro de um grupo.

### Autenticação (API)
- **Obter Usuário Autenticado**: Recupera o usuário autenticado via API.
  - `GET /api/user`: Retorna os detalhes do usuário autenticado.

## Instalação

1. Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    ```
2. Navegue até o diretório do projeto:
    ```bash
    cd seu-repositorio
    ```
3. Instale as dependências:
    ```bash
    composer install
    ```
4. Configure o arquivo `.env`:
    - Crie um arquivo `.env` com base no `.env.example` e configure as variáveis de ambiente, como banco de dados e credenciais de API.
    ```bash
    cp .env.example .env
    ```
5. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
6. Execute as migrações:
    ```bash
    php artisan migrate
    ```
7. Inicie o servidor:
    ```bash
    php artisan serve
    ```

## Testes

Para rodar os testes, execute:
```bash
php artisan test
