<?php

namespace Hgabka\KunstmaanPopupBundle\Helper;

use Doctrine\Common\Persistence\ManagerRegistry;
use Hgabka\KunstmaanExtensionBundle\Helper\KumaUtils;

class PopupHandler
{
    const TYPE_IMAGE = 'image';
    const TYPE_HTML = 'html';

    /** @var KumaUtils */
    protected $kumaUtils;

    /** @var ManagerRegistry */
    protected $doctrine;

    /**
     * PopupHandler constructor.
     *
     * @param ManagerRegistry $doctrine
     * @param KumaUtils       $kumaUtils
     */
    public function __construct(ManagerRegistry $doctrine, KumaUtils $kumaUtils)
    {
        $this->doctrine = $doctrine;
        $this->kumaUtils = $kumaUtils;
    }

    /**
     * @return array
     */
    public function getTypeChoices()
    {
        return $this
            ->kumaUtils
            ->prefixArrayElements([self::TYPE_IMAGE, self::TYPE_HTML], 'hgabka_kuma_popup.types.');
    }

    /**
     * @return KumaUtils
     */
    public function getKumaUtils(): KumaUtils
    {
        return $this->kumaUtils;
    }

    public function getPopup()
    {
        $possibleBanners = $this
            ->doctrine
            ->getRepository('HgabkaKunstmaanPopupBundle:Popup')
            ->getPopups($this->kumaUtils->getCurrentLocale())
        ;

        $displaySorsolo = [];
        foreach ($possibleBanners as $possibleBanner) {
            /** @var Popup $possibleBanner */
            $priority = $possibleBanner->getPriority();
            $priority = empty($priority) || $priority < 2 ? 2 : $priority;
            for ($i = 0; $i < $priority; ++$i) {
                $displaySorsolo[] = $possibleBanner;
            }
        }

        return empty($displaySorsolo) ? null : $displaySorsolo[array_rand($displaySorsolo)];
    }

    public function hasPopup()
    {
        $count = $this
            ->doctrine
            ->getRepository('HgabkaKunstmaanPopupBundle:Popup')
            ->countPopups($this->kumaUtils->getCurrentLocale())
        ;

        return $count > 0;
    }
}
