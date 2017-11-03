<?php
namespace ASCII\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLevel
 *
 * @ORM\Table(name="user_level", uniqueConstraints={@ORM\UniqueConstraint(name="user_level_name", columns={"user_level_name"})})
 * @ORM\Entity
 */
class UserLevel
{

    /**
     *
     * @var string @ORM\Column(name="user_level_name", type="string", length=32, nullable=false)
     */
    private $userLevelName;

    /**
     *
     * @var integer @ORM\Column(name="user_level_id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userLevelId;

    /**
     * Set userLevelName
     *
     * @param string $userLevelName
     *
     * @return UserLevel
     */
    public function setUserLevelName($userLevelName)
    {
        $this->userLevelName = $userLevelName;
        
        return $this;
    }

    /**
     * Get userLevelName
     *
     * @return string
     */
    public function getUserLevelName()
    {
        return $this->userLevelName;
    }

    /**
     * Get userLevelId
     *
     * @return integer
     */
    public function getUserLevelId()
    {
        return $this->userLevelId;
    }
}
