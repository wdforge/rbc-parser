<?php

namespace Parser\Model;


abstract class AbstractPdoModel
{
  /**
   * @var \PDO
   */
  private static $dbh;

  /**
   * Получение соединения
   *
   * @return \PDO
   */
  public static function getConnect()
  {
    return self::$dbh ? self::$dbh : self::initModel();
  }

  /**
   * Подключение к серверу БД
   *
   * @return \PDO
   */
  public static function connect($config = [])
  {
    $connect = function () use ($config){
      try {
        $dbh = new \PDO($config['connect'], $config['user'], $config['pass'], [\PDO::ATTR_PERSISTENT => true]);
      } catch (\PDOException $e) {
        echo("Error: " . $e->getMessage());
        die();
      }

      return $dbh;
    };

    self::$dbh = $connect();
    return self::$dbh;
  }

  /**
   * Получение результата SQL запроса на выборку
   *
   * @param $sql
   * @param array $params
   * @param bool $firstField
   * @return |null
   */
  public static function select($sql, $params = [], $firstField = false)
  {
    $result = null;
    if (!is_null(self::$dbh)) {
      try {
        $stmt = self::$dbh->prepare($sql);
        if ($stmt->execute($params)) {
          $result = $firstField ? $stmt->fetchAll(\PDO::FETCH_COLUMN) : $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
      } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
        error_log("Error: " . $e->getMessage());
        die();
      }
    }

    return $result;
  }

  /**
   * Метод вставки записей
   *
   * @param $table
   * @param array $params
   * @return bool
   */
  public static function insert($table, $params = [])
  {
    if (!$table || empty($params)) {
      return false;
    }
    $fields = array_keys($params);
    $isMultiRows = false;

    if (is_numeric($fields[0])) {
      $isMultiRows = true;
      $fields = array_keys($params[0]);
    }

    if (empty($fields)) {
      return false;
    }

    $sqlInsert = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, implode(', ', $fields), ':' . implode(', :', $fields));
    $insert = function ($data) use ($sqlInsert) {
      if (!is_null(self::$dbh) && is_array($data) && !empty($data)) {
        try {
          $stmt = self::$dbh->prepare($sqlInsert);
          $stmt->execute($data);
        } catch (\PDOException $e) {
          error_log("Error: " . $e->getMessage());
          return false;
        }
        return true;
      }
      return false;
    };

    if (!$isMultiRows) {
      return $insert($params);
    }

    foreach ($params as $row) {
      $insert($row);
    }

    return true;
  }

  /**
   * Удаление записей
   *
   * @param $table
   * @param array $expressions
   */
  public static function delete($table, $expressions = [])
  {
    $sqlDelete = sprintf('delete from %s where %s', $table, implode(' and ', $expressions));
    if (!is_null(self::$dbh)) {
      try {
        return self::$dbh->query($sqlDelete);
      } catch (\PDOException $e) {
        error_log("Error: " . $e->getMessage());
      }
    }
    return false;
  }

}