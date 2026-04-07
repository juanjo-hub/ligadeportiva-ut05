FROM node:20-alpine

WORKDIR /app

# Copiar package files e instalar dependencias
COPY package*.json ./
RUN npm install --omit=dev

# Copiar el resto del código
COPY . .

# Render asigna $PORT
EXPOSE 3000

CMD ["node", "index.js"]
