<?php
/*
 * @codingStandardsIgnoreFile
 *
 * Auto generated file ignore for Code Sniffer
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table(name="words", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code", "IdLanguage"}), @ORM\UniqueConstraint(name="code_2", columns={"code", "ShortCode"})})
 * @ORM\Entity
 *
 * @SuppressWarnings(PHPMD)
 * Auto generated class do not check mess
 */
class Word
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=128, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="ShortCode", type="string", length=16, nullable=false)
     */
    private $shortcode = 'en';

    /**
     * @var string
     *
     * @ORM\Column(name="Sentence", type="text", length=65535, nullable=false)
     */
    private $sentence;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="donottranslate", type="string", nullable=false)
     */
    private $donottranslate = 'no';

    /**
     * @var integer
     *
     * @ORM\Column(name="IdLanguage", type="integer", nullable=false)
     */
    private $idlanguage = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="IdMember", type="integer", nullable=false)
     */
    private $idmember = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="TranslationPriority", type="integer", nullable=false)
     */
    private $translationPriority = '5';

    /**
     * @var boolean
     *
     * @ORM\Column(name="isarchived", type="boolean", nullable=true)
     */
    private $isarchived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="majorupdate", type="datetime", nullable=false)
     */
    private $majorUpdate = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Word
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set shortcode
     *
     * @param string $shortcode
     *
     * @return Word
     */
    public function setShortcode($shortcode)
    {
        $this->shortcode = $shortcode;

        return $this;
    }

    /**
     * Get shortcode
     *
     * @return string
     */
    public function getShortcode()
    {
        return $this->shortcode;
    }

    /**
     * Set sentence
     *
     * @param string $sentence
     *
     * @return Word
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get sentence
     *
     * @return string
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Word
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set donottranslate
     *
     * @param string $donottranslate
     *
     * @return Word
     */
    public function setDonottranslate($donottranslate)
    {
        $this->donottranslate = $donottranslate;

        return $this;
    }

    /**
     * Get donottranslate
     *
     * @return string
     */
    public function getDonottranslate()
    {
        return $this->donottranslate;
    }

    /**
     * Set idlanguage
     *
     * @param integer $idlanguage
     *
     * @return Word
     */
    public function setIdlanguage($idlanguage)
    {
        $this->idlanguage = $idlanguage;

        return $this;
    }

    /**
     * Get idlanguage
     *
     * @return integer
     */
    public function getIdlanguage()
    {
        return $this->idlanguage;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Word
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set idmember
     *
     * @param integer $idmember
     *
     * @return Word
     */
    public function setIdmember($idmember)
    {
        $this->idmember = $idmember;

        return $this;
    }

    /**
     * Get idmember
     *
     * @return integer
     */
    public function getIdmember()
    {
        return $this->idmember;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Word
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set translationpriority
     *
     * @param integer $translationpriority
     *
     * @return Word
     */
    public function setTranslationPriority($translationPriority)
    {
        $this->translationPriority = $translationPriority;

        return $this;
    }

    /**
     * Get translationpriority
     *
     * @return integer
     */
    public function getTranslationPriority()
    {
        return $this->translationPriority;
    }

    /**
     * Set isarchived
     *
     * @param boolean $isarchived
     *
     * @return Word
     */
    public function setIsarchived($isarchived)
    {
        $this->isarchived = $isarchived;

        return $this;
    }

    /**
     * Get isarchived
     *
     * @return boolean
     */
    public function getIsarchived()
    {
        return $this->isarchived;
    }

    /**
     * Set majorupdate
     *
     * @param \DateTime $majorUpdate
     *
     * @return Word
     */
    public function setMajorUpdate($majorUpdate)
    {
        $this->majorUpdate = $majorUpdate;

        return $this;
    }

    /**
     * Get majorUpdate
     *
     * @return \DateTime
     */
    public function getMajorUpdate()
    {
        return $this->majorUpdate;
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
}
