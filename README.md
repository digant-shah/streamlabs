# Introduction
This is a coding solution for streamlab

- Initiating a websocket connection to Twitch API to listen to activities for the streamer.
- The second page shows live stream using twitch embedding service and top 10 activities

## Technologies
- Framework: Laravel 5.7
- Twitch API
- PHP 7.1
- NPM 6.3.0
- Bootstrap 4

## Twitch APIs used
- https://dev.twitch.tv/docs/authentication/
- https://dev.twitch.tv/docs/api/webhooks-guide/
- https://dev.twitch.tv/docs/v5/reference/search/#search-channels
- https://dev.twitch.tv/docs/embed/everything/

## Answers for questions
**Q1. How would you deploy the above on AWS? (ideally a rough architecture diagram will help)**

Ans. Ec2 instances + elastic loadbalancing

![Architecture Diagram](https://d1.awsstatic.com/Projects/Python/arch_diagram.3edf54fb1c8d9fdec47ff1950c81211798b27d6b.png)

The stack uses Linux, Apache, MySQL, and PHP. Using Elastic Beanstalk, you can simply upload your code and Elastic Beanstalk automatically handles the deployment, from capacity provisioning, load balancing, auto-scaling to application health monitoring. Elastic Beanstalk automatically scales your application up and down based on your application's specific need using easily adjustable Auto Scaling settings
**We are not using mysql as we don't require database right now for this solution**

We will need following commands to build the project.

```
git pull origin master

yarn
composer install

php artisan config:cache
composer dump-autoload
```

**Q2. Where do you see bottlenecks in your proposed architecture and how would you approach scaling this app starting from 100 reqs/day to 900MM reqs/day over 6 months?**

Ans. Autoscaling group with loadbalancer infront should handle our loads and allow us to handle any number of requests.
