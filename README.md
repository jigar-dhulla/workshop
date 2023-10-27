# Local Setup
- Clone Project

    ```git clone https://github.com/jigarakatidus/workshop.git```

- Create Network:

    ```docker network create todo```

- Build Web:

    ```docker build -t workshop .```

- Create Web

    ```docker run -d --network todo --name web -p 80:80 -v $(PWD):/var/www/html workshop```

- Create DB

    ```docker run -d --network todo --name db -p 3306:3306 -e MYSQL_ROOT_PASSWORD=secret -v ./data:/var/lib/mysql mysql:8.0```

- Create Database and Table

    ```docker exec -it db bash```

    Run the commands from `todo.sql` inside the container

- To Truncate DB:

    ```TRUNCATE TABLE todoapp```

- Access localhost

    ```http://localhost```

# Installing on AWS
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
## For s3
- bucket policy to make it public.
    ```
    {
        "Version": "2012-10-17",
        "Id": "PublicReadPolicy",
        "Statement": [
            {
                "Sid": "AllowPublicAccess",
                "Effect": "Allow",
                "Principal": "*",
                "Action": "s3:GetObject",
                "Resource": "arn:aws:s3:::laravel-pune-workshop/*"
            }
        ]
    }
    ```

## SSH Tunnel for RDS
```
ssh -i ~/Downloads/gomo-m1.pem -L 3306:todo.cxjvzwb8hlec.ap-south-1.rds.amazonaws.com:3306 ubuntu@ec2-3-110-134-145.ap-south-1.compute.amazonaws.com
```

# Topics for Workshop:
- EC2
- RDS
- Running PHP App Demo
- VPC
- S3
- Access RDS via SSH Tunnel