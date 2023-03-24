---------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id`INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE ,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
);

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `login`, `email`, `password`) VALUES
(6, 'Сергей', 'Дадухин', 'ducha2112', 'ducha2112@gmail.com', '$2y$10$NVBjoH/571VK03DtACR5UebYZ/HoDZ9AHnVaTrUop2Ml.HORYAI7S'),
(8, 'Василий', 'Пупкин', 'Vasia', 'Vasia@tg.ru', '$2y$10$YINPNCZrbGHn0DZVYDQrX.gpk.qjls55Peom/G88/8eWps2PggeDe'),
(10, 'Админ', 'Админ', 'admin', 'admin@admin', '$2y$10$LQMrXKZcOeizgiz0z1I0KOHNYt4x6IIbK9lDMftlr6qAc0gQBlTda'),
(11, 'Сергей', 'Дадухин', 'ducha', 'ducha2112@gmail.com', '$2y$10$TA7.b2Ap5hrc0cVoui6fne46B1/KlsiSnESRhVY.giKTa/CNgymU.'),
(13, 'Петр', 'Иванович', 'golub', 'golub@ya.ru', '$2y$10$SO6z1v5xHmg.8.TSCWrXp.b0JiBkJGT79xhtG0VRa0E18Az1lqjhi'),
(14, 'Леонард', 'Кузьмичев', 'leonard', 'leonard@leonard.com', '$2y$10$nxlGsRT52Ar79jNd3aLqfu1BYYRP8IivHxtcND.ejbbCwmpxDG.y2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--

-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
