<?php

namespace PrivlinkBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * privlink
 *
 * @ORM\Table(name="privlink")
 * @ORM\Entity(repositoryClass="PrivlinkBundle\Repository\privlinkRepository")
 */
class privlink
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;

    /**
     * @var int
     *
     * @ORM\Column(name="configuration", type="boolean", nullable=true)
     */
    private $configuration;

    /**
     * @var string $createdFromIp
     *
     * @Gedmo\ IpTraceable(on="create")
     * @ORM\Column(name="createdFromIp", length=45, nullable=true)
     */
    private $createdFromIp;

    /**
     * @var int $viewsCount
     *
     * @ORM\Column(name="viewsCount", type="integer", nullable=true)
     */
    private $viewsCount;

    /**
     * @var string $lastReviewFromIp
     *
     * @ORM\Column(name="lastReviewFromIp", length=45, nullable=true)
     */
    private $lastReviewFromIp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastReviewDate", type="datetime", nullable=true)
     */
    private $lastReviewDate;

    /**
     * @var int
     *
     * @ORM\Column(name="checkbox", type="boolean", nullable=true)
     */
    private $checkbox;

    /**
     * @var string $email
     *
     * @ORM\Column(name="sendToEmail", length=45, nullable=true)
     */
    private $email;


    /**Return string from configuration*/
    public function __toString()
    {
        try {
            return (string) $this->configuration;
        } catch (Exception $exception) {
            return '';
        }
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return privlink
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return privlink
     */
    public function setCreateDate($now)
    {
        $this->createDate = $now;
        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return privlink
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return privlink
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return privlink
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }
    
    /**
     * Set configuration
     *
     * @param boolean $configuration
     * @return privlink
     */

    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration
     *
     * @return boolean 
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Set createdFromIp
     *
     * @param string $createdFromIp
     * @return privlink
     */
    public function setCreatedFromIp($createdFromIp)
    {
        $this->createdFromIp = $createdFromIp;

        return $this;
    }

    /**
     * Get createdFromIp
     *
     * @return string 
     */
    public function getCreatedFromIp()
    {
        return $this->createdFromIp;
    }



    /**
     * Set viewsCount
     *
     * @param integer $viewsCount
     * @return privlink
     */
    public function setViewsCount($viewsCount)
    {
        $this->viewsCount = $viewsCount;

        return $this;
    }

    /**
     * Get viewsCount
     *
     * @return integer 
     */
    public function getViewsCount()
    {
        return $this->viewsCount;
    }

    /**
     * Set lastReviewFromIp
     *
     * @param string $lastReviewFromIp
     * @return privlink
     */
    public function setLastReviewFromIp($lastReviewFromIp)
    {
        $this->lastReviewFromIp = $lastReviewFromIp;

        return $this;
    }

    /**
     * Get lastReviewFromIp
     *
     * @return string 
     */
    public function getLastReviewFromIp()
    {
        return $this->lastReviewFromIp;
    }

    /**
     * Set lastReviewDate
     *
     * @param \DateTime $lastReviewDate
     * @return privlink
     */
    public function setLastReviewDate($lastReviewDate)
    {
        $this->lastReviewDate = $lastReviewDate;

        return $this;
    }

    /**
     * Get lastReviewDate
     *
     * @return \DateTime 
     */
    public function getLastReviewDate()
    {
        return $this->lastReviewDate;
    }

    /**
     * Set checkbox
     *
     * @param boolean $checkbox
     * @return privlink
     */
    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;

        return $this;
    }

    /**
     * Get checkbox
     *
     * @return boolean 
     */
    public function getCheckbox()
    {
        return $this->checkbox;
    }



    /**
     * Set email
     *
     * @param string $email
     * @return privlink
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}
