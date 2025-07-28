# 💻 Project explanation (Mytheresa Promotion Service)
This service implement an REST API endpoint that given a list of pre-stored products, allow to retrieve them with pagination, filtering and with applicable promotions.


## Table of Contents

<!-- TOC -->
* [💻 Project explanation](#table-of-contents)
    * [Given that](#-given-that)
    * [Requirements](#requirements)
    * [Environment Setup](#environment-setup)
    * [Installation](#installation)
    * [Make](#make)
* [🧩 Solution explanation](#solution-explanation)
    * [Code structure](#code-structure)
        * [src/](#src)
    * [Testing](#-testing-)
        * [tests/](#tests)
        * [Acceptance Tests](#acceptance-tests)
        * [Unit Tests](#unit-tests)
    * [API Documentation](#api-documentation)
        * [GET /products](#get-products)
* [🗯️ Possible improvements](#possible-improvements)
<!-- TOC -->



##  Given that

- Products in the boots category have a 30% discount.
- The product with sku = 000003 has a 15% discount. 
- When multiple discounts collide, the biggest discount must be applied.


## Requirements

- Docker & Docker Compose

## Environment Setup
- PHP 8.4
- Symfony 7.3
- Docker

## Installation

- Install the needed services by running `make up` in the application directory.
- After that, you can run all the tests at once by running `make tests`

## Make

I am using **Make** to automate the most common development tasks. You can type `make` to see all available targets:

<details open> 
<summary>Here you can find the list of available targets:</summary>

```
  up               Install required images and initialize your local environment
  shell            Opens an interactive shell
  test             Run all test suites
  test-unit        Run all tests under Unit suite
  test-acceptance  Run all tests under Acceptance suite
  data-seed        Forces data deletion on the database and imports the seeds from JSON files under storage folder 
                   ⚠️ Please do not change json format                 
```
</details>


# 🧩Solution explanation

## Code structure
<details open>
<summary> Here you can find the structure under src folder: </summary>

The code is structured using DDD and Hexagonal architecture, having also in mind CQRS even it's not implemented.
For the database seeding, I decided to create a bash script that calls two Cli commands to store the information provided by JSON into the database.
### src/

```scala
|-- Application 
|   |-- Assembler
|   |   `-- ProductReadModelAssembler.php //assembles all three entities to return the ProductReadModel  
|   |-- Exception // Custom exceptions
|   |   |-- BadRequestException.php
|   |   `-- PriceNotFoundExcpetion.php 
|   |-- Query  // Handlers are under Query so the application layer is prepared for CQRS, here you can find read only handlers.
|   |   |-- GetProductsQuery.php
|   |   `-- GetProductsQueryHandler.php 
|   `-- ReadModel
|       |-- Paginator.php
|       |-- Product.php
|       |-- ProductCollection.php
|       `-- ProductPaginator.php
|-- Domain
|   |-- Model // Also can be called Entity
|   |   |-- Price
|   |   |   |-- Currency.php 
|   |   |   |-- Price.php
|   |   |   `-- PriceRepository.php // Price interface repository
|   |   |-- Product
|   |   |   |-- Category.php 
|   |   |   |-- Product.php
|   |   |   |-- ProductRepository.php
|   |   |   `-- StockKeepingUnit.php // Value object in case SKU has any format validation needed
|   |   `-- Promotion
|   |       |-- Promotion.php
|   |       |-- PromotionRepository.php
|   |       `-- PromotionType.php
|   |-- Service
|   |   `-- PromotionEngine.php // Service in charge of calculating the price discount
|   `-- Shared
|       |-- AggregateRoot.php 
|       |-- Entity.php
|       `-- ValueObject.php
|-- Infrastructure
|   |-- Middleware
|   |   `-- ErrorMiddleware.php // Custom error middleware to return controlled response formats on exceptions
|   |-- Persistance
|   |   |-- Doctrine
|   |   |   |-- Mapping
|   |   |   |   |-- Price
|   |   |   |   |   |-- Currency.orm.xml
|   |   |   |   |   `-- Price.orm.xml
|   |   |   |   |-- Product
|   |   |   |   |   |-- Product.orm.xml
|   |   |   |   |   `-- StockKeepingUnit.orm.xml
|   |   |   |   `-- Promotion
|   |   |   |       `-- Promotion.orm.xml
|   |   |   `-- Types
|   |   |       |-- CategoryType.php
|   |   |       |-- CurrencyType.php
|   |   |       |-- PromotionType.php
|   |   |       `-- SkuType.php
|   |   `-- Repository
|   |       |-- Price
|   |       |   `-- DoctrinePriceRepository.php
|   |       |-- Product
|   |       |   `-- DoctrineProductRepository.php
|   |       `-- Promotion
|   |           `-- DoctrinePromotionRepository.php
|   `-- Symfony
|       `-- Kernel.php
`-- UserInterface // Splitted between Cli commands and Http requests
    |-- CLI // Cli commands used to generate needed data on the database
    |   |-- ImportProductsFromJsonCommand.php
    |   `-- ImportPromotionsFromJsonCommand.php
    |-- Exception
    |   `-- ExceptionHandler.php
    `-- Http // endpoint controllers
        |-- Controller
        |   |-- GetHealthzController.php
        |   `-- GetProductsController.php
        |        |-- Exception
        |        |   `-- HttpExceptionHandler.php
        `-- ResponseTransformer
            |-- GetProductsJsonTransformer.php
            |-- GetProductsTransformer.php
            |-- PaginatedJsonResponseTransformer.php
            `-- PaginatedResponseTransformer.php
```
</details>

## Testing 

Tests are splitted between unit and acceptance for now.

<details open>
<summary> Here you can find the structure under tests folder: </summary>

You might notice that I used a mirroring folder structure from src
### tests/

```scala
|-- Acceptance
|   `-- UserInterface
|       `-- Http
|           `-- Controller
|               `-- GetProductsEndpointCest.php
|-- Acceptance.suite.yml
|-- Integration
|-- Support
|   |-- AcceptanceTester.php
|   |-- Data
|   |-- FunctionalTester.php
|   |-- Helper
|   |-- UnitTester.php
|   `-- _generated
|       `-- AcceptanceTesterActions.php
|-- Unit
|   |-- Application
|   |   `-- Query
|   |       `-- GetProductsQueryHandlerTest.php
|   |-- Assembler
|   |   `-- ProductReadModelAssemblerTest.php
|   `-- Domain
|       |-- Model
|       |   |-- Price
|       |   |   `-- PriceTest.php
|       |   |-- Product
|       |   |   |-- ProductTest.php
|       |   |   `-- StockKeepingUnitTest.php
|       |   `-- Promotion
|       |       `-- PromotionTest.php
|       `-- Service
|           `-- PromotionEngineTest.php
```
</details> 
If you plan to run all test suites at once, you can run:

```
$ make test 
```
<details> 
<summary>Example output</summary>

```
PHPUnit 12.2.7 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.1
Configuration: ProjectFolder/mytheresa-promotion-test-php/phpunit.dist.xml

................                                                  16 / 16 (100%)

Time: 00:00.041, Memory: 18.00 MB

OK (16 tests, 35 assertions)
Codeception PHP Testing Framework v5.3.2 https://stand-with-ukraine.pp.ua
[Seed] 1930378790

App\Tests.Acceptance Tests (3) -----------------------------
✔ GetProductsEndpointCest: Test get products endpoint without filters return json list of products (0.20s)
✔ GetProductsEndpointCest: Test get products endpoint with filter invalid category return bad request (0.01s)
✔ GetProductsEndpointCest: Test get products endpoint with filter boots return json list of products (0.02s)
------------------------------------------------------------
Time: 00:00.482, Memory: 26.00 MB

OK (3 tests, 13 assertions)
```
</details>

### Acceptance Tests

In order to help me produce and run Acceptance tests I am using [Codeception](https://codeception.com/docs/APITesting).

To exclusively run acceptance test suites run:
```
$ make test-acceptance
```

### Unit Tests

For unit tests as base I'm using [Phpunit](https://docs.phpunit.de/en/12.2/), and to help me mocking Dummies, I'm using [Prophecy](https://github.com/phpspec/prophecy)

To exclusively run unit test suites run:
```
$ make test-unit
```


## API Documentation

### GET /products
```
curl --location --request GET 'http://localhost:8080/products
```
This endpoint returns the products, it has a pagination on top of it so only up to 5 records are returned each time.
The available filters are:

| Parameter        | Type   | Default  |                                                Description |
| -------------    |:------:|:--------:|-----------------------------------------------------------:|
| page             | int    | 1        |                                                page number |
| category         | string |          |         product category (boots, sandals, shoes, sneakers) |
| priceLessThan    | int    |          | price before discounts, it applies less or equals strategy |

Note that priceLessThan is an int, so you have to send cents. 

All parameters are optional


<details>
<summary>Example output</summary>

```json
{
    "data": [
        {
            "sku": "000001",
            "name": "BV Lean leather ankle boots",
            "category": "boots",
            "price": {
                "original": 89000,
                "final": 62300,
                "discount_percentage": "30%",
                "currency": "EUR"
            }
        },
        {
            "sku": "000002",
            "name": "BV Lean leather ankle boots",
            "category": "boots",
            "price": {
                "original": 99000,
                "final": 69300,
                "discount_percentage": "30%",
                "currency": "EUR"
            }
        },
        {
            "sku": "000003",
            "name": "Ashlington leather ankle boots",
            "category": "boots",
            "price": {
                "original": 71000,
                "final": 49700,
                "discount_percentage": "30%",
                "currency": "EUR"
            }
        },
        {
            "sku": "000004",
            "name": "Naima embellished suede sandals",
            "category": "sandals",
            "price": {
                "original": 79500,
                "final": 79500,
                "discount_percentage": null,
                "currency": "EUR"
            }
        },
        {
            "sku": "000005",
            "name": "Nathane leather sneakers",
            "category": "sneakers",
            "price": {
                "original": 59000,
                "final": 59000,
                "discount_percentage": null,
                "currency": "EUR"
            }
        }
    ],
    "total": 5,
    "page": 1,
    "limit": 5
} 
```
</details>


## Possible improvements

- Iterate over categories to make it an entity, and create a CRUD on top of it to allow agents create categories without tech help.
- Add an elasticsearch or algolia to be more efficient on data retrieval.
- Move the Cli commands logic into Http endpoints to allow the data creation manually.
- Once we have the first create endpoint, we can add Integration tests.
- Allow multicurrency
