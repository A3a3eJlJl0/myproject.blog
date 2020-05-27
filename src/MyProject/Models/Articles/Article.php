<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

/**
 * Class Article
 * @package MyProject\Models\Articles
 */
class Article extends ActiveRecordEntity
{
    //------------------------------------------  Vars  ----------------------------------------------------------------
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var int */
    protected $authorId;

    /** @var string */
    protected $createdAt;

    //------------------------------------------  Getters  ----------------------------------------------------------------
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }



    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }
    //------------------------------------------  Setters  ----------------------------------------------------------------
    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId)
    {
        $this->authorId = $authorId;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setAuthor(User $author)
    {
        $this->authorId = $author->getId();
    }
    //------------------------------------------  Others  ----------------------------------------------------------------
    protected static function getTableName(): string
    {
        return 'articles';
    }
}