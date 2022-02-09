# Fradoos

![PHPUnit](https://github.com/r0mdau/fradoos/actions/workflows/unit-tests.yml/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/r0mdau/fradoos/badge.svg?branch=main)](https://coveralls.io/github/r0mdau/fradoos?branch=main)

This project is a CRUD demo written in PHP. It's goal is to build a simple reliable and fast developing API
using :
- Hexagonal Architecture
- Domain Driven Design
- PHP
- [Slim micro framework](http://www.slimframework.com/)
- [Doctrine ORM](https://www.doctrine-project.org)
- [PHPunit](https://phpunit.de/) tests.

This demo project is under development. See todolist below. I mention commits in front of todo items to see the minimum
diff of code to produce to make it working.

## Quickstart

Prerequisites :
- plenty php7 packages
- [composer](https://getcomposer.org/)
- [docker](https://www.docker.com/)

Add this in your hosts file :
```
127.0.0.1 mysql-fradoos fradoos.local
```

Then prepare folders :
```bash
mkdir -p build/log/apache2/fradoos.local
mkdir -p build/log/fradoos.local
mkdir -p build/data/fradoos
chmod -R 777 build/log
```

Launch containers :
```bash
composer start
# or
docker-compose up
```
Phpmyadmin is available at http://localhost:8090

But for the first time you will need to create tables and the the schema before running the examples.
```bash
composer update-db
```

To launch unit tests, check code style and flush out bugs, run
```bash
composer verify
```

### CRUD client examples
Working Group CRUD
```bash
curl -XPOST fradoos.local:8080/workingGroup -d "name=ceo"
curl -XGET fradoos.local:8080/workingGroup/1
curl -XPUT fradoos.local:8080/workingGroup/1 -d "name=cto"
curl -XDELETE fradoos.local:8080/workingGroup/1
```

Create user adding a company
```bash
#create company
curl -XPOST fradoos.local:8080/company -d "name=bigbossindustry"
#create user with previous company
curl -XPOST fradoos.local:8080/user -d "name=toto&email=ko@email.fr&company=1"
```

Add working groups to user
```bash
curl -XPUT fradoos.local:8080/user/1 -d "name=toto&email=ko@email.fr&company=2&workingGroups[]=1&workingGroups[]=2"
```


## Domain details

- A user has a name and email, both are mandatory.
- A user work in a company but not mandatory
- A user can belong to many working groups
- A working group can belong to many users
- We can retrieve user's working groups, but not the opposite
- A company has a name
- A working group has a name

## Folder structure

### Application

To store everything exposed to external potential clients. Here it's a HTTP API.

We use `Presentations` to choose the content type you need to return. Using JSON here.

#### GET reserved keyword

To lose HTTP data exchanges, we use a reserved keyword `fields` in GET parameters to filter properties the client needs.
Example :
```bash
curl -XGET fradoos.local:8080/user?fields=id
-->
[{"id":2},{"id":3},{"id":4}]

curl -XGET fradoos.local:8080/user?fields=id,name
-->
[{"id":2,"name":"romain"},{"id":3,"name":"romain"},{"id":4,"name":"romain"}
```

If no fields is specified, all specified default properties are returned.

#### Swagger docs

Of course, swagger doc is presented through `/api-docs`.

### Domain

Here we find the logic, very important : the doctrine entities and interfaces to discuss from Application and
Infrastructure to Domain.

### Infrastructure

We don't put the mapping between entities and ORM in annotations in Domain entities. Instead they are in
`Infrastructure/Repository/Doctrine/Mapping`. So if we need to change Doctrine by something else, Domain entites stay
the same.

## Tests

You can disable the launch of a sql server in docker and use an alternative.

```bash
./run.sh
# to launch only unit tests
composer test-unit
# you need mysql running for infrastructure tests
composer test-infra
# to launch all tests
composer test
```

## Composer Scripts

Mutliple composer scripts to help daily tasks.

## TODOs

Click on commit id to see changes

- [x] [75eddfe](https://github.com/r0mdau/fradoos/commit/75eddfe458ad039f23e19352e72ccef5eaa5cc55) Upgrade slimframework
- [x] [75eddfe](https://github.com/r0mdau/fradoos/commit/75eddfe458ad039f23e19352e72ccef5eaa5cc55) Upgrade Doctrine orm
- [x] [75eddfe](https://github.com/r0mdau/fradoos/commit/75eddfe458ad039f23e19352e72ccef5eaa5cc55) Upgrade PHPUnit
- [ ] Add specifications
- [x] [f6c467e](https://github.com/r0mdau/fradoos/commit/f6c467e333580c6f100815ee1d7e3fd323ae2279) Implement MessageLog class
- [ ] Use abstraction of databases to test Infrastructure, perhaps sqlite in memory
- [ ] Add entities history change management
- [ ] Add flyway to automatically maintain database structure with new entities in other environments than local
- [ ] Add Doctrine Second Level Cache
- [ ] Mermaid class diagram
- [ ] Update README.md after all todos

Add more entities to show links using doctrine
- [x] [1b92c10](https://github.com/r0mdau/fradoos/commit/1b92c102456ec90c9a7f019872827db85a94e596) ManyToOne
- [ ] OneToMany
- [x] [5eff472](https://github.com/r0mdau/fradoos/commit/5eff472f7a3c2125bbf07feba4b5de5af19ea895) Simple CRUD : associated with ManyToMany below
- [x] [8a7584f](https://github.com/r0mdau/fradoos/commit/8a7584f80ec2354fdf65370766331d33680cf2ff) ManyToMany
- [ ] Inheritance
