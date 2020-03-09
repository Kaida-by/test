**Тестовый проект**

Для разворачиванияя проета используйте [composer](https://getcomposer.org/).

В командной строке необходимо написать:

`composer create-project kaida-by/test`

Создание миграций производится путем последовательного ввода в командной строке следующих команд:

`php bin/console make:migration`

`php bin/console doctrine:migrations:migrate`

Для дальнейшего создания фикстур необходмо в командной строке ввести:

`php bin/console doctrine:fixture:load`

После ввода этих команд у Вас в БД появятся таблицы: ***user, product, profile user_profile***.

Таблицы будут заполненны данными, которые были описаны в файле: ***App\DataFixtures\AppFixtures***.

