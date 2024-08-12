# Test task: calculate product price

## Commands

```shell
### Start
docker compose up -d
docker compose exec sio_test bash

### Migrations
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load

### Run tests
bin/phpunit

```

#### Fixtures load countries, coupons and test products
##### Countries
- Germany, code: GE, tax rate - 19
- France, code: FR, tax rate - 20
- Italy, code: IT, tax rate - 22
- Greece, code: GR, tax rate - 24
##### Coupons
- P10 (10% coupon)
- P15 (15% coupon)
- F50 (50 fixed discount)
- F25 (25 fixed discount)
##### Coupons
- iPhone, 100 (id - 1)
- Headphones, 20 (id - 2)

## Commands to check the functionality (CURL)
### Calculate examples
```shell

curl -X POST http://localhost:8337/calculate-price \
-H "Content-Type: application/json" \
-d '{
    "product": 1,
    "taxNumber": "FR123456789",
    "couponCode": "F50"
}'

```
### Free product in total
```shell

curl -X POST http://localhost:8337/calculate-price \
-H "Content-Type: application/json" \
-d '{
    "product": 2,
    "taxNumber": "FR123456789",
    "couponCode": "F50"
}'

```
### Without coupon 
```shell

curl -X POST http://localhost:8337/calculate-price \
-H "Content-Type: application/json" \
-d '{
    "product": 2,
    "taxNumber": "FR123456789"
}'

```
### Percent discount
```shell

curl -X POST http://localhost:8337/calculate-price \
-H "Content-Type: application/json" \
-d '{
    "product": 2,
    "taxNumber": "IT12345678900",
    "couponCode": "P10"
}'

```
### and purchase example

```shell

curl -X POST http://localhost:8337/purchase \
-H "Content-Type: application/json" \
-d '{
    "product": 1,
    "taxNumber": "FR123456789",
    "couponCode": "F50",
    "paymentProcessor": "paypal"
}'


```