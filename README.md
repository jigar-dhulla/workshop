Create Network:
```docker network create todo```

Build Web:
```docker build -t workshop .```

Create Web
```docker run -d --network todo --name web -p 80:80 -v $(PWD):/var/www/html workshop```

Create DB
```docker run -d --network todo --name db -p 3306:3306 -e MYSQL_ROOT_PASSWORD=secret -v ./data:/var/lib/mysql mysql:8.0```

Create Database and Table
```docker exec -it db bash```
Run the commands from `todo.sql` inside the container

Truncate DB
```TRUNCATE TABLE todoapp```

Access localhost

Installing on AWS
- Create EC2 Instance
    - Install Ubuntu 22.04 AMI
    - Install Apache, PHP and PHP MySQL Extension

        `sudo apt install apache2 php libapache2-mod-php php-mysql`
    - Clone the project
        `cd /var/www/html`

        `sudo rm -rf index.html`

        `git clone https://github.com/jigarakatidus/workshop.git .`

    - Give correct permission to files and directory
- Create RDS
    - Update index.php and toggle.php with database credentials.