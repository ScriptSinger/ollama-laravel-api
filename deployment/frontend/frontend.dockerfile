# Базовый образ
FROM node:20

ARG UID=1000
ARG GID=1000

WORKDIR /app

# Копируем package.json и lock
COPY ./frontend/package*.json ./

# Устанавливаем зависимости от root (npm install может требовать прав)
RUN npm install -g npm@11.5.2

# Меняем владельца на node с нужным UID/GID
RUN usermod -u $UID node && groupmod -g $GID node \
    && chown -R node:node /app

# Переключаемся на пользователя node с обновлёнными UID/GID
USER node

# Копируем остальной код
COPY ./frontend .

CMD ["npm", "run", "dev", "--", "--host"]
