[![author-check](https://github.com/Marre-86/manul-shop/actions/workflows/author-check.yml/badge.svg)](https://github.com/Marre-86/manul-shop/actions/workflows/author-check.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/ee834f6a71fc0ca2cf33/maintainability)](https://codeclimate.com/github/Marre-86/ecommerce/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/ee834f6a71fc0ca2cf33/test_coverage)](https://codeclimate.com/github/Marre-86/ecommerce/test_coverage)

# Desription

["Manul Shop"](https://manul-shop-production.up.railway.app/) is a simple e-commerce web platform with rich token-based API. It has been developed by [Artem Pokhiliuk](https://www.linkedin.com/in/artem-pokhiliuk/) as a training project in Laravel framework with a wide variety of related techs usage.

The users of this platform are entitled to view available products (applying a wide range of filter, if needed), add them to a shopping cart and make an order. Authenticated users have access to the history of their orders and can cancel them in case they haven't been confirmed (by admin) yet.

Admins have access to the extensive 'underwater' part of this application, where they can manage (add, update and delete) products, categories and orders.

Majority of these operations is available in two ways: in the browser and by API.

Whoever is reading this and wants to fiddle with the app, is free to either register with the app on his own or use the following credentials to log in, for saving some time:

| Name             | Role  | Email | Password |
|------------------|-------|-------|----------|
| Robb Jones       | admin | a@a   | aaaaaa   |
| John Persimonn   | -     | s@s   | ssssss   |
| Yulia Pesochkina | -     | d@d   | dddddd   |

# About this project

This app was developed in the **Laravel PHP framework** (ver. 10.0), and only cutting-edge approaches and techniques were used.

As an authentication module, the combination of Laravel Breeze and Laravel Sanctum was incorporated into the project. Breeze implements standard auth features for the web interface of the app. Sanctum issues and verifies API tokens for users requesting app by API.

The special role of *'admin'* can be assigned to a user. This role has an extensive list of permissions - actions that regular users cannot commit. The Laravel Permission package from Spatie was used for implementing this feature.

All user data is stored in the **PostgreSQL database**. Operations of storing and extracting database data are implemented through Laravel's built-in **ORM Eloquent**. Migration files are written, models and relationships between them (o2m, m2m) are developed and implemented. Initial DB populating with a set of dummy data has been accomplished by using seeders.

The page, displaying available products has been developed in **Vue.js**. It dynamically changes the content of the page in accordance with user's actions (changing search filters) in no time by means of fetching data from the API. This page was seamlessly embedded into the skeleton of this Laravel-based project. Vue Router was used for linking this product page with the main navbar categories dropdown.

A RESTful API has been created for this project. A nice-looking representation of all existing endpoints and the HTTP methods with examples of requests and responses can be found on the main web-page of a project. Here's the short roundup: 

**server url** - https://manul-shop-production.up.railway.app/api/v1:

- **POST /register** - sign up for this application.
- **POST /login** - log in to this application.
- **GET /listing-categories/tree** - returns a tree of categories.
- **POST /category** - adds a new category. Requires authorization.
- **GET /products** - returns a list of products in the database.
- **GET /cart** - returns the content of the shopping cart. Requires authorization.
- **POST /cart** - adds a product with specified id into the cart. Requires authorization.
- **PATCH /cart** - updates the quantity of a product with specified id into the cart. Requires authorization.
- **DELETE /cart/:id** - removes product with specified id from the cart. Requires authorization.
- **POST /orders** - creates a new order consisting of all items in the cart. Requires authorization.
- **GET /orders** - returns list of orders made by authenthiticated user. Requires authorization.
- **GET /orders/:id** - returns detailed info about the order of authenthiticated user by ID. Requires authorization.
- **DELETE /orders/:id** - deletes the order of authenthiticated user by ID. Requires authorization.

[OpenAPI file](https://github.com/Marre-86/manul-shop/blob/main/public/openapi.yaml) has been written, meticulously describing the entire API.

Controller methods processing API requests are covered by automated tests based on PHPUnit and Laravel built-in assertion methods. [Additional package](https://github.com/kirschbaum-development/laravel-openapi-validator) has been integrated into these tests, it checks incoming requests and outcoming responses for compliance with aforementioned OpenAPI spec.

Web-interface controller methods are also extensively covered by tests. A test coverage report from **Codeclimate** was attached to this project and the overall percentage is seen at the top of this readme.

**GitHub Actions** CI/CD workflow for this project was also created and tuned in a way that every commit is instantly being built, tested and deployed if no errors were found. **Railway** deployment platform [hosts](https://manul-shop-production.up.railway.app/) this web app. Also it is linked to the real-time error tracking platform **Rollbar**.
