# Fradoos

This project is a CRUD demo written in PHP. It's goal is to build a simple reliable and fast developing API
using :
- Hexagonal Architecture
- Domain Driven Design
- PHP
- [Slim micro framework](http://www.slimframework.com/) 
- [Doctrine ORM](https://www.doctrine-project.org)
- [PHPunit](https://phpunit.de/) tests.

This demo project is under development. See todolist below.

## Quickstart

Prerequisites : 
- plenty php7 packages
- [composer](https://getcomposer.org/)
- [docker](https://www.docker.com/)

Add this in your hosts file :
```
127.0.0.1 mysql-fradoos fradoos.local
```

Then start the project :
```bash
./run.sh
```

But for the first time you will need to create tables to run examples.
```bash
composer update-db
```

Phpmyadmin is available at http://localhost:8090

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
# you need mysql running \o/ todos
./run.sh
composer test
```

## Composer Scripts

Mutliple composer scripts to help daily tasks.

## TODOs
- [x] Upgrade slimframework
- [x] Upgrade Doctrine orm
- [x] Upgrade PHPUnit
- [ ] Add specifications
- [x] Implement MessageLog class
- [ ] Use abstraction of databases to test Infrastructure, perhaps sqlite in memory
- [ ] Add entities history change management
- [ ] Add flyway to automatically maintain database structure with new entities in other environments than local
- [ ] Add Doctrine Second Level Cache
- [ ] Mermaid class diagram
- [ ] Update README.md after all todos

Add more entities to show links using doctrine
- [x] ManyToOne
- [ ] OneToMany
- [x] ManyToMany
- [ ] Inheritance
