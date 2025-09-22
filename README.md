# 🛠️ Sistema de Gerenciamento de Estoque

Um genrenciador de estoque de grande escala com dashboard, sessão de registro de produtos, gerenciamento de produto e notificações essenciais como baixa de estoque

## 🚀 Requisitos

- 🐘 PHP 8.0+
- 🎼 Composer
- 🟢 Node.js
- 🐳 Docker

## ⚙️ Instalação

1. Clone o repositório:

   ```bash
   git clone git@github.com:henriquesantosdev/inventory-manager.git
   ou
   https://github.com/henriquesantosdev/inventory-manager.git

   cd inventory-manager
   ```

2. Instale as dependências:

   ```bash
   composer install
   php artisan key:generate
   
   npm install
   npm run dev
   ```

3. Configure o `.env`:

   ```bash
   cp .env.example .env
   ```

## ▶️ Inicialização

1. Suba os containers:

   ```bash
   docker compose up
   ```

2. Inicie o servidor Laravel:

   ```bash
   php artisan serve
   ```

O sistema estará disponível em [http://localhost:8000](http://localhost:8000) 🌐.
