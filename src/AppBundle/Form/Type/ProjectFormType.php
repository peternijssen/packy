<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('repositoryType', 'choice', array(
                'choices' => array('github' => 'Github', 'gitlab' => 'Gitlab', 'bitbucket' => 'Bitbucket'),
            ))
            ->add('repositoryUrl')
            ->add('vendorName')
            ->add('packageName')
            ->add('branch');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\Project',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    }
}
