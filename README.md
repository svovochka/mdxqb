# Simple MDX query builder (Exam task)
1) Init autoloader

``$ docker-compose -f docker-compose-install.yml up``

2) Run php 7.4 in docker

``$ docker-compose up``

3) SSH into container

``$ docker exec -it mdxqb_php-fpm_1 /bin/bash``

4) Try demo scripts from /examples directory (mounted to /app into container)

``$ php /app/examples/15_cross_join_non_empty_3.php ``