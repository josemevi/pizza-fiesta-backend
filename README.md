# pizza-fiesta-backend

to run locally clone the project inside your htdocs (if using xampp) and create a database named "pizza_fiesta" then run "pizza_fiesta.sql" ç

Make sure to configure inside config db_connect your db username and password by default is root and no password.

API live at (14/07/2021): https://pizza-fiesta-api.000webhostapp.com/

Api request examples: 

-- USERS
POST 
/api/v1/users/register.php

{ 
    "email": "pruebaaa@prueba.com",
    "username": "pruebaaa",
    "password": "12345",
    "phone": "23423434",
    "direction": "mi casa"

} 

POST 
api/v1/users/login.php
{ 
    "username": "Prueba",
    "password": "12345"

} 

-- PIZZAS

POST 
api/v1/pizzas/createPizza.php
{ 
    "name": "Lomo Suprema 3",
    "ingredients": ["Piña", "Jamon", "Coco"],
    "value": "500",
    "created_by": 1,
    "description": "",
     "photo": "https://media.istockphoto.com/photos/picking-slice-of-pepperoni-pizza-picture-id1133727757?k=6&m=1133727757&s=612x612&w=0&h=6wLUhTKLTudlkgLXQxdOZIVr6D9zuIcMJhpgTVmOWMo="

} 

PUT
api/v1/pizzas/updatePizza.php
{ 
    "name": "Lomo Suprema",
    "ingredients": ["Piña", "Quesito", "Anchoas"],
    "value": "69",
    "updated_by": 8,
    "description": "Lomito",
    "pizza_id": 16,
    "photo": ""

} 

DELETE
api/v1/pizzas/deletePizza.php?id=3

GET 
api/v1/pizzas/getPizzas.php

GET 
api/v1/pizzas/getPizzas.php?id=16

GET 
http://localhost/pizza-fiesta-backend/api/v1/pizzas/getUserPizzas.php?id=8


-- CART
POST 
api/v1/cart/createCartEntry.php
{ 
    "user_id": 8,
    "pizza_id": 17
} 

DELETE
api/v1/cart/deleteCartEntry.php?id=6

GET
api/v1/cart/getUserCart.php?id=1

GET
cart/getUserCartCount.php?id=2


-- ORDERS

POST 
api/v1/orders/createOrder.php
{
    "user_id" : 8
}

GET 
api/v1/orders/getOrders.php

GET 
api/v1/orders/getOrders.php?id=5

GET 
api/v1/orders/getUserOrders.php?id=8