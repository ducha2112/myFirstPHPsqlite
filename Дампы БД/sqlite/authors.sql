

CREATE TABLE `authors` (
                           `id`PRIMARY KEY NOT NULL,
                           `first_name` varchar(255) NOT NULL,
                           `last_name` varchar(255) NOT NULL,
                           `avatar` varchar(255) NOT NULL
);

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`, `avatar`) VALUES
(1, 'Денис', 'Петров', 'images/authors/petrov.jpg'),
(2, 'Алексей', 'Манихин', 'images/authors/manihin.jpg'),
(3, 'Петр', 'Крашенинников', 'images/authors/krasheninnikov.jpg'),
(4, 'Анна', 'Борисова', 'images/authors/borisova.jpg');

--