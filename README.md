# A Simple Symfony API with users and their skills 

You will need php installed;

Run CMD,
navigate to our project folder then:

# install composer
composer install

# setup our database

edit .env file in DATABASE_URL line with your mysql login:pass@ip:port/database_name 

DATABASE_URL=mysql://login:password@127.0.0.1:3306/api_db

# using doctrine to manager our db
create our database based on .env file config:
php bin/console doctrine:database:create

then running the migrations to create the tables in our db:
php bin/console doctrine:migrations:migrate

# to run with built-in web server:
php -S localhost:8080 -t public

# endpoints 
// I've used Postman for tests

# POST Method
submitting a new skill: http://localhost:8080/skill/new

{
    "skillDesc": "PHP Developer"
}

creating a new user: http://localhost:8080/register

{
    "username": "John Doe",
    "password": "password",
    "email": "jhon@doe.com",
    "skillId": 1
}

# GET Method 
getting all users: http://localhost:8080/users

getting all skills: http://localhost:8080/skills

getting user by id: http://localhost:8080/user/ID (example: http://localhost:8080/user/3)

getting skill by id: http://localhost:8080/skill/ID (example: http://localhost:8080/skill/2)

getting all users by skill id: http://localhost:8080/skill/ID/users (example: http://localhost:8080/skill/2/users)

# PUT Method
updating a skill by id: http://localhost:8080/skill/id/update (example http://localhost:8080/skill/3/update)

{
    "skillDesc": "C++ Developer"
}


updating a user by id: http://localhost:8080/user/id/update (example http://localhost:8080/user/1/update)

{
    "username": "xixi",
    "password": "2020",
    "email": "apx@mail.com",
    "skillId": 4
}

# DELETE Method
deleting user by id: http://localhost:8080/user/id/delete (example http://localhost:8080/user/5/delete) 

deleting a skill by id: http://localhost:8080/skill/id/delete (example http://localhost:8080/skill/3/delete)




