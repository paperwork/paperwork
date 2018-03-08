FROM mhart/alpine-node:latest

RUN apk update \
 && apk add python2 make curl postgresql-client

# get ContainerPilot release
ENV CONTAINERPILOT_VERSION 2.7.2
RUN export CP_SHA1=e886899467ced6d7c76027d58c7f7554c2fb2bcc \
    && curl -Lso /tmp/containerpilot.tar.gz \
         "https://github.com/joyent/containerpilot/releases/download/${CONTAINERPILOT_VERSION}/containerpilot-${CONTAINERPILOT_VERSION}.tar.gz" \
    && echo "${CP_SHA1}  /tmp/containerpilot.tar.gz" | sha1sum -c \
    && tar zxf /tmp/containerpilot.tar.gz -C /bin \
    && rm /tmp/containerpilot.tar.gz

# add ContainerPilot configuration
COPY containerpilot.json /etc/containerpilot.json
ENV CONTAINERPILOT=file:///etc/containerpilot.json

COPY run.sh /usr/local/bin/run.sh

WORKDIR /app
COPY . .

RUN npm install \
 && npm run compile \
 && rm -rf node_modules \
 && npm install --production \
 && apk del python2 make

CMD ["/bin/containerpilot", "/usr/local/bin/run.sh", "database-kong"]
