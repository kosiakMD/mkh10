-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 05 2016 г., 17:28
-- Версия сервера: 5.6.17
-- Версия PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `powertext`
--
CREATE DATABASE IF NOT EXISTS `powertext` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `powertext`;

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_categories`
--

CREATE TABLE `pwt_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `sorting_field` int(10) UNSIGNED NOT NULL,
  `sorting_type` int(10) UNSIGNED NOT NULL,
  `created` date NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_events`
--

CREATE TABLE `pwt_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(1) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_logs`
--

CREATE TABLE `pwt_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `pwt_logs`
--

INSERT INTO `pwt_logs` (`id`, `user_id`, `action`, `ip`, `date`) VALUES
(1, 1, 'Створення резервної копії БД', 2130706433, '2016-02-05 17:27:30'),
(2, 1, 'Вихід з системи', 2130706433, '2016-02-05 17:28:06');

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_messages`
--

CREATE TABLE `pwt_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_navigations`
--

CREATE TABLE `pwt_navigations` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activity` tinyint(1) NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `blank` tinyint(1) NOT NULL,
  `href` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `pwt_navigations`
--

INSERT INTO `pwt_navigations` (`id`, `title`, `activity`, `position`, `type`, `blank`, `href`, `icon`, `updated`) VALUES
(1, 'Головна', 1, 1, 1, 0, '', 'home', '2015-08-29 17:05:01');

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_pages`
--

CREATE TABLE `pwt_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `activity` tinyint(1) NOT NULL,
  `fullscreen` tinyint(1) NOT NULL,
  `details` tinyint(1) NOT NULL,
  `visits` int(10) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_stats`
--

CREATE TABLE `pwt_stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED DEFAULT '1',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `pwt_stats`
--

INSERT INTO `pwt_stats` (`id`, `count`, `date`) VALUES
(1, 29, '2016-02-05');

-- --------------------------------------------------------

--
-- Структура таблицы `pwt_users`
--

CREATE TABLE `pwt_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `privileges` int(10) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `pwt_users`
--

INSERT INTO `pwt_users` (`id`, `login`, `password`, `privileges`, `active`, `updated`) VALUES
(1, 'Admin', '25d55ad283aa400af464c76d713c07ad', 4, 1, '2016-02-05 17:18:26');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pwt_categories`
--
ALTER TABLE `pwt_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `pwt_events`
--
ALTER TABLE `pwt_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `pwt_logs`
--
ALTER TABLE `pwt_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `pwt_messages`
--
ALTER TABLE `pwt_messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pwt_navigations`
--
ALTER TABLE `pwt_navigations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pwt_pages`
--
ALTER TABLE `pwt_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`,`category_id`),
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `pwt_stats`
--
ALTER TABLE `pwt_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Индексы таблицы `pwt_users`
--
ALTER TABLE `pwt_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pwt_categories`
--
ALTER TABLE `pwt_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `pwt_events`
--
ALTER TABLE `pwt_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `pwt_logs`
--
ALTER TABLE `pwt_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `pwt_messages`
--
ALTER TABLE `pwt_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `pwt_navigations`
--
ALTER TABLE `pwt_navigations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `pwt_pages`
--
ALTER TABLE `pwt_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pwt_stats`
--
ALTER TABLE `pwt_stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT для таблицы `pwt_users`
--
ALTER TABLE `pwt_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `pwt_categories`
--
ALTER TABLE `pwt_categories`
  ADD CONSTRAINT `pwt_categories_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `pwt_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pwt_events`
--
ALTER TABLE `pwt_events`
  ADD CONSTRAINT `pwt_events_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `pwt_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pwt_logs`
--
ALTER TABLE `pwt_logs`
  ADD CONSTRAINT `pwt_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pwt_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pwt_pages`
--
ALTER TABLE `pwt_pages`
  ADD CONSTRAINT `pwt_pages_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `pwt_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pwt_pages_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `pwt_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
