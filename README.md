# PUROBook

## Descrição

PUROBook é uma rede social exclusiva para estudantes da Universidade Federal Fluminense (UFF) do campus de Rio das Ostras. O objetivo é criar um espaço online onde os alunos possam se conectar, compartilhar informações, discutir temas relevantes ao curso e à vida acadêmica, e fortalecer a comunidade universitária.

## Funcionalidades

*   **Cadastro:** Novos usuários podem se cadastrar na plataforma, fornecendo informações como nome, e-mail e senha.
*   **Login:** Usuários cadastrados podem fazer login no sistema para acessar a rede social.
*   **Posts:** Usuários podem criar posts de texto para compartilhar ideias, notícias, perguntas ou qualquer outro conteúdo relevante.
*   **Comentários:** Usuários podem comentar em posts de outros usuários, promovendo discussões e interação.
*   **Foto de Perfil:** Usuários podem adicionar uma foto de perfil para personalizar sua conta.
*   **Seleção de Curso:** Usuários podem selecionar o curso que estão cursando na UFF, facilitando a conexão com colegas da mesma área.
*   **Deletar Post e Comentários:** Usuários podem excluir seus próprios posts e seus comentários nos posts de outras pessoas.

## Tecnologias Utilizadas

*   **PHP 5.2.1:** Linguagem de programação utilizada no backend do sistema.
*   **MySQL:** Banco de dados utilizado para armazenar informações dos usuários, posts, comentários, etc.
*   **HTML, CSS e JavaScript:** Tecnologias utilizadas no frontend para criar a interface do usuário e adicionar interatividade.
*   **WampServer:** Ambiente de desenvolvimento local utilizado para testar o sistema.

## Instalação e Configuração

1.  **Requisitos:**
    *   WampServer instalado e configurado.
    *   PHP 5.2.1 (ou compatível).
    *   MySQL.
2.  **Instalação:**
    *   Clone este repositório:
        ```bash
        git clone https://github.com/not-felipe/PUROBook.git
        ```
    *   Coloque os arquivos na pasta `www` do WampServer.
    *   Crie um banco de dados MySQL para o PUROBook.
    *   Importe o script SQL para criar as tabelas necessárias.
3.  **Configuração:**
    *   Edite o arquivo de configuração do banco de dados (em `config/`) e insira as informações de conexão com o banco de dados MySQL.
        
            ```php
            <?php
            $host = 'localhost';
            $usuario = 'root';
            $senha = '';
            $banco = 'blog_db';
            ?>
            ```

## Utilização

1.  **Cadastro:**
    *   Acesse a página de cadastro (`/cadastro.php` ou similar).
    *   Preencha o formulário com suas informações e clique em "Cadastrar".
2.  **Login:**
    *   Acesse a página de login (`/login.php` ou similar).
    *   Insira seu e-mail e senha e clique em "Entrar".
3.  **Página Inicial:**
    *   Após o login, você será redirecionado para a página inicial, onde poderá ver os posts de outros usuários.
4.  **Criar um Post:**
    *   Clique no botão "Novo Post" ou similar.
    *   Escreva seu post e clique em "Publicar".
5.  **Comentar em um Post:**
    *   Abaixo de cada post, há um campo para adicionar um comentário.
    *   Escreva seu comentário e clique em "Comentar".
6.  **Adicionar Foto de Perfil:**
    *   Acesse a página de perfil (`/perfil.php` ou similar).
    *   Clique no botão "Alterar Foto" ou similar.
    *   Selecione uma imagem do seu computador e clique em "Salvar".
7.  **Selecionar Curso:**
    *   Na página de perfil, selecione o seu curso na lista de opções.
    *   Clique em "Salvar".
8.  **Excluir Post/Comentário:**
    *   Por fim, caso deseje, o usuário pode excluir seus posts e comentários que foram feitos anteriormente.
## Informações Adicionais

*   **Projeto da Disciplina de Desenvolvimento Web:** Este projeto foi desenvolvido para a disciplina de Desenvolvimento Web na Universidade Federal Fluminense (UFF) e ainda está em desenvolvimento.
*   **Em Desenvolvimento:** O PUROBook ainda está em fase de desenvolvimento e pode conter bugs ou funcionalidades incompletas.
