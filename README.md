Test
==============

In this test, I didn't do all that I planned because of the lack of time. I hope you understand this. But anyway, I've
tried to pay attention to the most significant parts. In the code, you can see some typos, missing PHPdocs sometimes and
I didn't always keep SOLID principles. But all these things I would be glad to consider with the person who will be able
to check this test. The main parts that I didn't do (unfortunately) here:

- caching
- logging
- I didn't support here any headers (except HTTP methods, of course).
- tests
- in controllers, I think it is a good idea to use DTOs directly instead of the Request object.
- I didn't provide here a possibility to add or update 'Artist' entity. Actually, I don't support 'Artist's in this API.
- versioning API
- I skipped 'PUT' and left supporting only 'PATCH'
- Automatic installation
- Instead of validation of the `name` (it should be unique) of the `Record`, we have here 500 error
- Authentication
- I didn't polish the code and in real-life, if I reviewed this code I would block this :)

If it won't be enough to assess me, please contact me aleksanderlebedenko@gmail.com. I'm always open to discuss and
append missing parts.

# Installation

First, clone this repository:

```bash
$ git clone git@github.com:Aleksanderlebedenko/OetTest.git
```

Then got to the directory. Then, run:

```bash
$ docker-compose up
```

Then got the php container and run migrations

```bash
$ docker exec -it php-fpm sh

$ composer install

$ php bin/console doctrine:migrations:migrate
```

You are done, you can visit page with the API documentation page on the following URL: `http://localhost`

_Note :_ you can rebuild all Docker images by running:

```bash
$ docker-compose build
```

# Environment Customizations

# Read logs

You can access Nginx and Symfony application logs in the following directories on your host machine:

* `logs/nginx`
* `logs/symfony`


# Tips
If during the testing especially via swagger you will see some `502 Bad Gateway` error, you can avoid it via using incognito mode or via postman