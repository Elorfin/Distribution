<?php

namespace Icap\BlogBundle\Form;

use Icap\BlogBundle\Form\DataTransformer\IntToBlogTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Zenstruck\Bundle\FormBundle\Form\DataTransformer\AjaxEntityTransformer;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("icap_blog.form.widget_tag_list_blog")
 * @DI\FormType(alias = "blog_widget_tag_list_blog_form")
 */
class WidgetTagListBlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resourceNode', 'resourcePicker', array(
                'theme_options' => array(
                    'label_width'   => 'col-md-6',
                    'control_width' => 'col-md-6'
                ),
                'attr' => array(
                    'data-restrict-for-owner'             => 1,
                    'data-is-picker-multi-select-allowed' => 0,
                    'data-is-directory-selection-allowed' => 0,
                    'data-type-white-list'                => 'icap_blog',
                    'data-display-download-button'        => 0,
                    'data-display-browse-button'          => 0
                )
            ))
            ->add('tag_cloud', 'choice', array(
                'choices'       => array("0" => "classic", "1" => "3D", "2" => "advanced"),
                'required'      => false,
                'expanded'      => true,
                'multiple'      => false,
                'empty_value'   => false
            ));
    }

    public function getName()
    {
        return 'blog_widget_tag_list_blog_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'         => 'Icap\BlogBundle\Entity\WidgetTagListBlog',
                'translation_domain' => 'icap_blog'
            )
        );
    }
}