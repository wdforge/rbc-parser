
--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `body` text CHARACTER SET utf8,
  `image` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
