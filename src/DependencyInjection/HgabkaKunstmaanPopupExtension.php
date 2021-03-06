<?php

namespace Hgabka\KunstmaanPopupBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HgabkaKunstmaanPopupExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $voterDefinition = $container->getDefinition('hgabka_kunstmaan_popup.popup_voter');
        $voterDefinition->replaceArgument(1, $config['editor_role']);

        $menuAdaptorDefinition = $container->getDefinition('hgabka_kunstmaan_popup.menu.adaptor.popup');
        $menuAdaptorDefinition->replaceArgument(1, $config['editor_role']);

        $container->setParameter('hgabka_kunstmaan_popup.editor_role', $config['editor_role']);
    }
}
