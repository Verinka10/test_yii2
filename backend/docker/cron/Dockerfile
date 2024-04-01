#FROM ubuntu:latest
FROM yiisoftware/yii2-php:8.2-apache

# Install Cron
RUN apt-get update
RUN apt-get -y install cron

# Add the cron job
#RUN crontab -l | { cat; echo "* * * * * date >> /app/backend/web/cron.log"; } | crontab -

# Copy
COPY cron.d/yii-cron /etc/cron.d/yii-cron
RUN chmod 0644 /etc/cron.d/yii-cron
RUN crontab /etc/cron.d/yii-cron
 
RUN touch /var/log/cron.log
CMD cron && tail -f /var/log/cron.log

#CMD cron
