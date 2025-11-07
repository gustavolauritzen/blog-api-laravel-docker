FROM php:8.2-fpm

  # Definir variáveis
  ARG user=laravel
  ARG uid=1000

  # Instalar dependências do sistema
  RUN apt-get update && apt-get install -y \
      git \
      curl \
      libpng-dev \
      libonig-dev \
      libxml2-dev \
      zip \
      unzip \
      nginx

  # Limpar cache do apt
  RUN apt-get clean && rm -rf /var/lib/apt/lists/*

  # Instalar extensões do PHP
  RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

  # Instalar Composer (gerenciador de pacotes do PHP)
  COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

  # Criar usuário para rodar o Laravel
  RUN useradd -G www-data,root -u $uid -d /home/$user $user
  RUN mkdir -p /home/$user/.composer && \
      chown -R $user:$user /home/$user

  # Definir diretório de trabalho
  WORKDIR /var/www

  # Copiar aplicação
  COPY --chown=$user:$user . /var/www

  # Mudar para o usuário criado
  USER $user