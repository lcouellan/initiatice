<?php

namespace initiatice\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="forum_question")
 * @ORM\Entity(repositoryClass="initiatice\AdminBundle\Repository\ForumQuestionRepository")
 */
class ForumQuestion extends ForumPost
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}