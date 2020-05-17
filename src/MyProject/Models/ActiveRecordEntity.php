<?php

namespace MyProject\Models;

use MyProject\Models\Articles\Article;
use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    //-------------------------------------------- Vars ----------------------------------------------------------------
    protected $id;

    //-------------------------------------------- Private -------------------------------------------------------------
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('~(?<!^)[A-Z]~', '_$0', $source));
    }

    private function insert(array $mappedProperties)
    {
        $columns = [];
        $params = [];
        $params2values = [];
        $index = 1;
        $filteredProperties = array_filter($mappedProperties);
        foreach ($filteredProperties as $column => $value) {
            $param = ':param' . $index;
            $columns[] = $column;
            $params[] = $param;
            $params2values[$param] = $value;
            $index++;
        }
        $sql = 'INSERT into ' . static::getTableName() . ' (' . implode(',', $columns) . ') VALUES(' . implode(',', $params) . ');';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();

        $entity = self::getById($this->id);
        foreach ($this as $property=>$value){
            if($value === null){
                $this->$property = $entity->$property;
            }
        }
    }

    private function update(array $mappedProperties)
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $columns2params[] = $column . '=' . $param;
            $params2values[$param] = $value;
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(',', $columns2params) . ' WHERE id=' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    //-------------------------------------------- Public --------------------------------------------------------------
    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $classProperties = $reflector->getProperties();
        foreach ($classProperties as $classProperty) {
            $propertyName = $classProperty->getName();
            $underscoredPropertyName = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$underscoredPropertyName] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    public static function findAll(): array
    {
        return Db::getInstance()->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    abstract protected static function getTableName(): string;

    public static function getById(int $id): ?self
    {
        $entities = Db::getInstance()->query('SELECT * FROM `' . static::getTableName() . '` WHERE `id`=:id;', [':id' => $id], static::class);
        return $entities ? $entities[0] : null;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id === null) {
            $this->insert($mappedProperties);
        } else {
            $this->update($mappedProperties);
        }
    }

    public function delete()
    {
        $sql = 'DELETE FROM `'.static::getTableName().'` WHERE id = :id;';
        $db = Db::getInstance();
        $db->query($sql, [':id' => $this->id]);
        $this->id = null;
    }


}
