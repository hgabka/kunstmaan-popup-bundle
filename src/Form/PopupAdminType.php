<?php

namespace Hgabka\KunstmaanPopupBundle\Form;

use Hgabka\KunstmaanExtensionBundle\Form\Type\DateTimepickerType;
use Hgabka\KunstmaanPopupBundle\Helper\PopupHandler;
use Kunstmaan\AdminBundle\Form\WysiwygType;
use Kunstmaan\MediaBundle\Form\Type\MediaType;
use Kunstmaan\NodeBundle\Form\Type\URLChooserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Routing\RouterInterface;

class PopupAdminType extends AbstractType
{
    /** @var PopupHandler */
    protected $handler;

    /** @var RouterInterface */
    protected $router;

    /**
     * BannerAdminType constructor.
     *
     * @param PopupHandler    $handler
     * @param RouterInterface $router
     */
    public function __construct(PopupHandler $handler, RouterInterface $router)
    {
        $this->handler = $handler;
        $this->router = $router;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'hgabka_kuma_popup.labels.name', 'required' => true])
            ->add(
                'type',
                ChoiceType::class,
                [
                    'label' => 'hgabka_kuma_popup.labels.type',
                    'expanded' => true,
                    'choices' => array_flip($this->handler->getTypeChoices()),
                    'required' => true,
                ]
            )
            ->add('media', MediaType::class, [
                'label' => 'hgabka_kuma_popup.labels.media',
                'required' => false,
                'attr' => ['info_text' => ''],
                'mediatype' => 'image',
                'foldername' => 'banner',
            ])
            ->add('imageAlt', TextType::class, [
                'label' => 'hgabka_kuma_popup.labels.image_alt',
                'required' => false,
            ])
            ->add('imageTitle', TextType::class, [
                'label' => 'hgabka_kuma_popup.labels.image_title',
                'required' => false,
            ])
            ->add('html', WysiwygType::class, [
                'label' => 'hgabka_kuma_popup.labels.html',
                'required' => false,
            ])
            ->add('url', URLChooserType::class, [
                'link_types' => [URLChooserType::INTERNAL, URLChooserType::EXTERNAL],
                'label' => 'hgabka_kuma_popup.labels.url',
                'required' => false,
            ])
            ->add('newWindow', null, [
                'label' => 'hgabka_kuma_popup.labels.new_window',
                'required' => false,
            ])
            ->add('start', DateTimepickerType::class, [
                'required' => false,
                'label' => 'hgabka_kuma_popup.labels.start',
                'locale' => 'hu',
            ])
            ->add('end', DateTimepickerType::class, [
                'required' => false,
                'label' => 'hgabka_kuma_popup.labels.end',
                'locale' => 'hu',
            ])
            ->add('priority', IntegerType::class, [
                'label' => 'hgabka_kuma_popup.labels.priority',
                'required' => false,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $banner = $event->getData();
                $cultures = $this->handler->getKumaUtils()->getLocaleChoices();
                if (count($cultures) < 2) {
                    $banner->setLocale($this->handler->getKumaUtils()->getDefaultLocale());
                }

                if (empty($banner->getLocale())) {
                    $banner->setLocale(null);
                }
            })
        ;
        $cultures = $this->handler->getKumaUtils()->getLocaleChoices();
        if (count($cultures) > 1) {
            $builder->add('locale', ChoiceType::class, [
                'label' => 'hgabka_kuma_popup.labels.locale',
                'choices' => array_flip($cultures),
                'required' => false,
                'placeholder' => 'hgabka_kuma_popup.locales.all',
            ]);
        }
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'hgabka_kunstmaanpopup_popup_type';
    }
}
