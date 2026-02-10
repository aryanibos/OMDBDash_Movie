# Gunakan image PHP 7.4 dengan Apache (Versi paling stabil untuk Laravel 5.8)
FROM php:7.4-apache

# Install dependencies sistem yang dibutuhkan (Gunakan --no-install-recommends agar tidak menimpa Apache bawaan)
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Fix: Pastikan tidak ada MPM ganda. 
# Hapus konfigurasi mpm_event dan mpm_worker jika ada (bawaan Debian terkadang terinstall)
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    /etc/apache2/mods-enabled/mpm_event.conf \
    /etc/apache2/mods-enabled/mpm_worker.load \
    /etc/apache2/mods-enabled/mpm_worker.conf
# Jangan hapus mpm_prefork bawaan image, dan jangan paksa a2enmod lagi jika sudah aktif.

# Install Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy file project
COPY . .

# Install dependencies project (tanpa dev dependencies untuk production)
RUN composer install --optimize-autoloader --no-dev

# Ubah permission folder storage dan bootstrap cache agar bisa ditulisi
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ganti DocumentRoot Apache ke folder public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
