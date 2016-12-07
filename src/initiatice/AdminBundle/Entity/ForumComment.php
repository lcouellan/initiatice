<?php

namespace initiatice\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="forum_comment")
 * @ORM\Entity(repositoryClass="initiatice\AdminBundle\Repository\ForumCommentRepository")
 */
class ForumComment extends ForumPost
{
    /**
     * @var int
     *
     * @ORM\Column(name="question_id", type="integer")
     */
    private $questionId;

    /**
     * @return int
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * @param int $questionId
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }

}