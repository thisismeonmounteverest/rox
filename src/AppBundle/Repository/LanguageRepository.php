<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Language;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 */
class LanguageRepository extends EntityRepository
{
    /**
     * Returns all languages for which translations exist
     *
     * @return array Language
     */
    public function getLanguagesWithTranslations($locale)
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMappingBuilder($entityManager);
        $rsm->addRootEntityFromClassMetadata(Language::class, 'l');

        $query = $entityManager->createNativeQuery("SELECT 
    l.*, w2.Sentence 'TranslatedName'
FROM
    languages l
LEFT JOIN
    words w1 ON l.id = w1.IdLanguage
left JOIN
	words w2 ON w2.ShortCode = '{$locale}' and w2.Code = l.WordCode 
WHERE
    w1.code = 'WelcomeToSignup'
ORDER BY name ASC", $rsm);
        return $query->getResult();
    }
}
