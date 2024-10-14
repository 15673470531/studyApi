FROM php:8.1-fpm

# 检查文件是否存在且为空
#RUN [ -s /etc/apt/sources.list ] || touch /etc/apt/sources.list

#RUN sed -i 's|deb.debian.org|mirrors.tuna.tsinghua.edu.cn|g' /etc/apt/sources.list.d/debian.source && \
#    sed -i 's|security.debian.org|mirrors.tuna.tsinghua.edu.cn|g' /etc/apt/sources.list.d/debian.source

# 创建 /etc/apt 目录
#RUN mkdir -p /etc/apt

# 创建空的 sources.list 文件
#RUN touch /etc/apt/sources.list

#清华源
#RUN sed -i 's#deb http://archive.ubuntu.com/ubuntu/ bionic main#deb https://mirrors.tuna.tsinghua.edu.cn/ubuntu/ noble main restricted universe multiverse#g' /etc/apt/sources.list

#RUN set -i "crpi-qla5t7bva3oihm65.cn-shenzhen.personal.cr.aliyuncs.com/haitun-docker/io" /etc/apt/sources.list

#RUN sed -i "deb https://mirrors.tuna.tsinghua.edu.cn/ubuntu/ noble main restricted universe multiverse" /etc/apt/sources.list
#RUN set -i "deb https://mirrors.tuna.tsinghua.edu.cn/ubuntu/ noble-updates main restricted universe multiverse" /etc/apt/sources.list
#RUN set -i "deb https://mirrors.tuna.tsinghua.edu.cn/ubuntu/ noble-backports main restricted universe multiverse" /etc/apt/sources.list



#RUN sed -i "1ideb https://mirrors.aliyun.com/debian/ bullseye main non-free contrib" /etc/apt/sources.list
#RUN sed -i "2ideb-src https://mirrors.aliyun.com/debian/ bullseye main non-free contrib" /etc/apt/sources.list
#RUN sed -i "3ideb https://mirrors.aliyun.com/debian-security/ bullseye-security main" /etc/apt/sources.list
#RUN sed -i "4ideb-src https://mirrors.aliyun.com/debian-security/ bullseye-security main" /etc/apt/sources.list
#RUN sed -i "5ideb https://mirrors.aliyun.com/debian/ bullseye-updates main non-free contrib" /etc/apt/sources.list
#RUN sed -i "6ideb-src https://mirrors.aliyun.com/debian/ bullseye-updates main non-free contrib" /etc/apt/sources.list
#RUN sed -i "7ideb https://mirrors.aliyun.com/debian/ bullseye-backports main non-free contrib" /etc/apt/sources.list
#RUN sed -i "8ideb-src https://mirrors.aliyun.com/debian/ bullseye-backports main non-free contrib" /etc/apt/sources.list
#RUN sed -i 's/https:\/\/mirrors.aliyun.com/http:\/\/mirrors.cloud.aliyuncs.com/g' /etc/apt/sources.list
#
#RUN sed -i 's/deb.debian.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apt/sources.list && \
#    sed -i 's/security.debian.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apt/sources.list


# 安装所需的依赖包和扩展
#RUN apt-get update && apt-get install -y \
#        git \
#        curl \
#        libpng-dev \
#        libonig-dev \
#        libxml2-dev \
#        zip \
#        unzip \
#        vim \
#        bash \
#        iputils-ping \
#    && docker-php-ext-install mysqli pdo pdo_mysql mbstring exif pcntl bcmath gd

#RUN apt-get -o Acquire::http::Timeout=5 -o Acquire::Retries=3 update && apt-get install -y && docker-php-ext-install mysqli pdo pdo_mysql mbstring exif pcntl bcmath gd
RUN apt-get update && apt-get install -y && docker-php-ext-install mysqli pdo pdo_mysql mbstring exif pcntl bcmath gd

# 清理缓存
RUN rm -rf /var/lib/apt/lists/*

# 安装 Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 设置工作目录
WORKDIR /var/www/html

# 复制 Laravel 项目文件到容器中并安装依赖
COPY . /var/www/html

#RUN cd /var/www/html && composer install --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

#RUN composer install --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist -vvv


# 设置文件和目录的权限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage
