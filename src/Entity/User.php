<?php
namespace ASCII\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="user_mail", columns={"user_mail"})}, indexes={@ORM\Index(name="user_level_id", columns={"user_level_id"})})
 * @ORM\Entity
 */
class User
{

    /**
     *
     * @var string @ORM\Column(name="user_mail", type="string", length=128, nullable=false)
     */
    private $userMail;

    /**
     *
     * @var string @ORM\Column(name="user_password", type="string", length=128, nullable=false)
     */
    private $userPassword;

    /**
     *
     * @var integer @ORM\Column(name="user_id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     *
     * @var UserLevel @ORM\ManyToOne(targetEntity="ASCII\Entity\UserLevel", cascade={"persist"})
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="user_level_id", referencedColumnName="user_level_id")
     *      })
     */
    private $userLevel;

    /**
     * Set userMail
     *
     * @param string $userMail
     *
     * @return User
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;
        
        return $this;
    }

    /**
     * Get userMail
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     *
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
        
        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userLevel
     *
     * @param \ASCII\Entity\UserLevel $userLevel
     *
     * @return User
     */
    public function setUserLevel(\ASCII\Entity\UserLevel $userLevel = null)
    {
        $this->userLevel = $userLevel;
        
        return $this;
    }

    /**
     * Get userLevel
     *
     * @return UserLevel
     */
    public function getUserLevel()
    {
        return $this->userLevel;
    }
}
