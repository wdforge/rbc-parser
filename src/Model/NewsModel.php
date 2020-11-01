<?php

namespace Parser\Model;

/**
 * Класс для работы с новостями
 *
 * Class NewsModel
 * @package Parser\Model
 */
class NewsModel extends GenericPdoModel
{
  private static $table = 'news';

  public static function getAll(): ?array
  {
    return static::select('select * from news');
  }

  public static function getById(int $id): ?array
  {
    $result = static::select(sprintf('select * from news where id=%d', $id));
    return empty($result) ? false: reset($result);
  }

  /**
   * Очистка таблицы
   *
   * @return false|\PDOStatement
   */
  public static function cleanTable() {
    return self::execute('truncate table '.static::$table);
  }

  /**
   * Дрбавление записи
   *
   * @param array $params
   * @return bool
   */
  public static function add($params = [])
  {
    return self::insert(static::$table, $params);
  }

}