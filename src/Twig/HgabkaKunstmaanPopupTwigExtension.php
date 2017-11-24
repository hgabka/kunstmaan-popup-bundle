<?php

namespace Hgabka\KunstmaanPopupBundle\Twig;

use Hgabka\KunstmaanPopupBundle\Helper\PopupHandler;
use Symfony\Component\HttpFoundation\Session\Session;

class HgabkaKunstmaanPopupTwigExtension extends \Twig_Extension
{
    const SESSION_PARAM = 'hgabka_popup_shown';

    /**
     * @var PopupHandler
     */
    protected $handler;

    /** @var Session */
    protected $session;

    /**
     * PublicTwigExtension constructor.
     *
     * @param PopupHandler $handler
     * @param Session      $session
     */
    public function __construct(PopupHandler $handler, Session $session)
    {
        $this->handler = $handler;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('show_popup', [$this, 'showPopup'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new \Twig_SimpleFunction('has_popup', [$this, 'hasPopup'], [
            ]),
        ];
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @return string
     */
    public function showPopup(\Twig_Environment $environment)
    {
        if ($this->session->get(self::SESSION_PARAM, false)) {
            return '';
        }

        $popup = $this->handler->getPopup();

        if (!$popup) {
            return '';
        }

        $this->session->set(self::SESSION_PARAM, true);

        return $environment->render('@HgabkaKunstmaanPopup/popup/show.html.twig', ['popup' => $popup]);
    }

    public function hasPopup()
    {
        return $this->handler->hasPopup();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hgabka_kunstmaan_popup.popup_twig_extension';
    }
}
