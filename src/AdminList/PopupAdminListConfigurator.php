<?php

namespace Hgabka\KunstmaanPopupBundle\AdminList;

use Doctrine\ORM\EntityManager;
use Hgabka\KunstmaanPopupBundle\Entity\Popup;
use Hgabka\KunstmaanPopupBundle\Form\PopupAdminType;
use Hgabka\KunstmaanPopupBundle\Helper\PopupHandler;
use Kunstmaan\AdminBundle\Helper\Security\Acl\AclHelper;
use Kunstmaan\AdminListBundle\AdminList\Configurator\AbstractDoctrineORMAdminListConfigurator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class PopupAdminListConfigurator extends AbstractDoctrineORMAdminListConfigurator
{
    /** @var RouterInterface */
    protected $router;
    /** @var AuthorizationChecker */
    private $authChecker;

    /** @var PopupHandler */
    private $handler;

    /** @var string */
    private $editorRole;

    /**
     * @param EntityManager $em        The entity manager
     * @param AclHelper     $aclHelper The acl helper
     */
    public function __construct(EntityManager $em, AuthorizationChecker $authChecker, PopupHandler $handler, RouterInterface $router, string $editorRole, AclHelper $aclHelper = null)
    {
        parent::__construct($em, $aclHelper);
        $this->handler = $handler;
        $this->authChecker = $authChecker;
        $this->editorRole = $editorRole;

        $this->setAdminType(PopupAdminType::class);
    }

    /**
     * Configure the visible columns.
     */
    public function buildFields()
    {
        $this->addField('name', 'hgabka_kuma_popup.labels.name', true);
        $this->addField('start', 'hgabka_kuma_popup.labels.start', false);
        $this->addField('end', 'hgabka_kuma_popup.labels.end', false);
    }

    /**
     * Build filters for admin list.
     */
    public function buildFilters()
    {
    }

    /**
     * Get bundle name.
     *
     * @return string
     */
    public function getBundleName()
    {
        return 'HgabkaKunstmaanPopupBundle';
    }

    /**
     * Get entity name.
     *
     * @return string
     */
    public function getEntityName()
    {
        return 'Popup';
    }

    public function getListTitle()
    {
        return 'Popup-ok';
    }

    /**
     * Returns edit title.
     *
     * @return null|string
     */
    public function getEditTitle()
    {
        return 'Popup szerkesztése';
    }

    /**
     * Returns new title.
     *
     * @return null|string
     */
    public function getNewTitle()
    {
        return 'Új popup';
    }

    public function getAddTemplate()
    {
        return 'HgabkaKunstmaanPopupBundle:AdminList:Popup\add_or_edit.html.twig';
    }

    public function getEditTemplate()
    {
        return 'HgabkaKunstmaanPopupBundle:AdminList:Popup\add_or_edit.html.twig';
    }

    /**
     * @return PopupHandler
     */
    public function getHandler(): PopupHandler
    {
        return $this->handler;
    }

    public function canAdd()
    {
        return $this->authChecker->isGranted($this->editorRole);
    }

    public function canEdit($item)
    {
        return $this->authChecker->isGranted(PopupVoter::EDIT, $item);
    }

    public function canDelete($item)
    {
        return $this->authChecker->isGranted(PopupVoter::EDIT, $item);
    }

    public function canExport()
    {
        return false;
    }
}
