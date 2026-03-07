FROM node:20-alpine as builder
WORKDIR /app

COPY package.json ./ 
RUN npm install

COPY . .
RUN rm -rf node_modules package-lock.json \
    && npm cache clean --force \
    && npm install \
    && npm run build

FROM nginx:alpine
COPY --from=builder /app/dist /usr/share/nginx/html
EXPOSE 80