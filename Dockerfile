FROM mhart/alpine-node:latest

RUN apk update \
 && apk add python2 make

WORKDIR /app
COPY . .

RUN npm install \
 && npm run compile \
 && rm -rf node_modules \
 && npm install --production \
 && apk del python2 make

CMD ["node", "--harmony", "/app/compiled/Server.js"]
