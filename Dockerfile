FROM php:8.2-apache

# 1. ติดตั้ง Library ของ Linux ที่จำเป็นสำหรับรูปภาพ (GD)
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# 2. ติดตั้ง Extension ของ PHP ที่ต้องใช้กับ MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3. เปิดใช้งาน mod_rewrite
RUN a2enmod rewrite

# 4. ตั้งค่าโฟลเดอร์งาน
WORKDIR /var/www/html/ng4
COPY ./src /var/www/html/ng4/
RUN chown -R www-data:www-data /var/www/html/ng4