### Подготовка проекта
Чтобы развернуть проект используйте команду
docker compose up -d

# № 1
### 1.1 Задание
http://localhost:8089/?client_ids=1,2,3
Можно передать список user_id и получить товары с заданной сортировкой и тд

### 1.2 Задание
http://localhost:8089/good-form.php

```json
[
    {
        "title": "Hello",
        "price": 15.15
    },
    {
        "title": "World",
        "price": 12.70
    }
]
```

### 1.3 Задание
1.3.1 Поменял поле title на чтобы нельзя было его оставлять пустым (NULL), так как в любом случаи должно быть поле title без него никак 
``` sql
CREATE TABLE products (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  price decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

1.3.2 Добавить внешние ключи для таблицы user_order для полей user_id и product_id 
``` sql 
CREATE TABLE user_order (
  user_id int NOT NULL,
  product_id int NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY user_order_FK (user_id),
  KEY user_order_FK_1 (product_id),
  CONSTRAINT user_order_FK FOREIGN KEY (user_id) REFERENCES user (id),
  CONSTRAINT user_order_FK_1 FOREIGN KEY (product_id) REFERENCES products (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

1.3.3 Так же можно создать такой индекс 
``` sql
CREATE INDEX idx_products_title_price ON products(title, price DESC);
```
(но нужно проверять на реальных кейсах)

# № 2
Реализуется прицип ООП полиморфизм, есть абстрактный класс Car с абстрактным методом go(), два класса RaceCar и Track наследуются от Car и реализуют метод go() по-своему. В цикле мы вызываем go() не заботясь о том какого конкретного типа этот объект. В общем это помогает нам работать с объектами разных классов единообразно через общий интерфейс(здесь мы используем абстрактный класс Car), это дает нам возможность добавлять новый тип машины без изменение кода в цикле foreach.

# № 3
В чем отличие SQL от MySQL?
SQL язык запросов, а MySQL это уже полноценное система управление базами данных.

# № 4 
Сделайте реализацию паттерна Singelton. Посмотрите, можно ли его применить в первом задании.

Класс PDOConnection является singleton так как он не будет заново создавать экземпляр instance который в свою очередь дает возможность не соединятся заново с БД mysql, а брать уже существующее соединение.