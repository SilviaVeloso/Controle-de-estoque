# Controle de Estoque

Este projeto é uma aplicação para gerenciamento de controle de estoque. Segue uma estrutura organizada baseada no padrão MVC (Model-View-Controller) para maior modularidade e escalabilidade.

## Estrutura do Projeto

plaintext
Controle-de-estoque/

├── assets/

│   └── css/

├── config/

├── controllers/

├── models/

├── views/

├── README.md

├── index.php

├── login.php

└── logout.php


### Descrição das Pastas e Arquivos

- *assets/*: Contém arquivos estáticos usados na aplicação.
  - *css/*: Arquivos CSS para estilização da interface.

- *config/*: Arquivos de configuração, incluindo parâmetros para banco de dados e outras configurações essenciais.

- *controllers/*: Contém os controladores responsáveis pela lógica da aplicação e a comunicação entre modelos e vistas.

- *models/*: Modelos que representam as entidades da aplicação e sua lógica de negócios.

- *views/*: Arquivos de interface que são apresentados ao usuário final.

- *README.md*: Arquivo de documentação do projeto.

- *index.php*: Ponto de entrada principal da aplicação.

- *login.php*: Gerencia o processo de autenticação de usuários.

- *logout.php*: Realiza o logout dos usuários.

## Requisitos do Sistema

- Servidor Web com suporte a PHP.
- Banco de dados MySQL.

## Como Executar

1. Clone o repositório:
   bash
   git clone https://github.com/SilviaVeloso/Controle-de-estoque.git
   

2. Configure o banco de dados:
   - Importe o arquivo SQL fornecido (se disponível).
   - Atualize as configurações no arquivo correspondente em *config/*.

3. Suba o servidor local:
   bash
   php -S localhost:8000
   

4. Acesse no navegador:
   
   http://localhost:8000
   

## Funcionalidades

- Cadastro de produtos.
- Gerenciamento de estoque.
- Relatórios de movimentação de estoque.
- Login e logout para acesso seguro.

## Contribuição

Contribuições são bem-vindas! Por favor, siga as diretrizes abaixo:

1. Faça um fork do projeto.
2. Crie uma branch com sua funcionalidade ou correção de bug:
   bash
   git checkout -b minha-feature
   
3. Faça o commit de suas alterações:
   bash
   git commit -m "Adicionei uma nova funcionalidade"
   
4. Envie suas alterações para a branch principal:
   bash
   git push origin minha-feature
   
5. Crie um Pull Request no repositório original.

## Licença

Este projeto está licenciado sob a licença MIT. Consulte o arquivo LICENSE para mais informações.

---

Feito com 💻 por Silvia Veloso e colaboradores
