#select all users first/last name who made a purchase of products from "Office" category in "Rite Aid" shop for last 10 years
SELECT first_name, last_name
FROM `users`
         JOIN orders on orders.user_id = users.user_id
         JOIN order_product on orders.order_id = order_product.id
         JOIN products on order_product.product_id = products.product_id
         JOIN product_category on products.product_id = product_category.id
WHERE DATE(orders.date) BETWEEN DATE_sub(DATE(NOW()), INTERVAL 10 YEAR) AND NOW()
  AND orders.shop_id = 3
  AND product_category.category_id = 9;

#select names of all categories and count the number of purchases of products from that category
SELECT category_id, COUNT(order_id)
FROM order_category
GROUP by category_id;

#select users first/last name who have more then one purchase in "Kroger" shop
SELECT users.first_name, users.last_name
FROM (SELECT orders.user_id, COUNT(orders.shop_id) counts
      FROM orders
      WHERE orders.shop_id = 1
      group BY orders.user_id
      HAVING counts > 1) s
         join users on users.user_id = s.user_id;

#show profit amount per month by particular shop (Might be useful in reporting)
SELECT DATE_FORMAT(orders.date, '%y'), DATE_FORMAT(orders.date, '%m'), sum(orders.sum)
FROM orders
GROUP BY Year(orders.date), Month(orders.date);

#search a user by it's full name oк part of it
SELECT CONCAT(first_name, " ", last_name) full_name
FROM users
where CONCAT(first_name, " ", last_name) LIKE '%A% %Kli%'
limit 1;

#show amount of all purchases made by a user
SELECT users.first_name, users.last_name, sum(orders.sum)
FROM users
         join orders on users.user_id = orders.user_id
GROUP by users.user_id;

#select users first/last name who have purchases only at "Kroger" shop
SELECT users.first_name, users.last_name
FROM users
         join orders on users.user_id = orders.user_id
         join(select user_id, COUNT(DISTINCT orders.shop_id) counts from orders GROUP by user_id) s
             on orders.user_id = s.user_id
WHERE orders.shop_id = 1
  and s.counts = 1
GROUP By users.user_id;

#select users first/last name who have purchases purchases in all shops (обратите внимание, всех магазинов, то есть запрос должен продолжать правильно работать даже если я вручную добавлю в базу еще магазинов и покупок)
SELECT users.first_name, users.last_name
FROM users
         join (SELECT count(DISTINCT orders.shop_id) shCount, (orders.order_id) userid
               FROM orders
               GROUP by orders.user_id) ss on ss.userId = users.user_id
WHERE ss.shCount = (select COUNT(shops.shop_id) from shops)
