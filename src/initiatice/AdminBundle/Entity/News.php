<?php

namespace initiatice\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="initiatice\AdminBundle\Repository\NewsRepository")
 */
class News extends Post
{

}
