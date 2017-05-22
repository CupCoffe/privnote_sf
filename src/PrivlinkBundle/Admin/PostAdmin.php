<?php
// src/Acme/BlogBundle/Admin/PostAdmin.php

namespace PrivlinkBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends Admin
{
    /**
     * Конфигурация отображения записи
     *
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->addIdentifier('text', null, array('label' => 'Text'))
            ->add('createDate', null, array('label' => 'Create Date'))
            ->add('endDate', null, array('label' => 'End Date'))
            ->add('password', null, array('label' => 'Password'))
            ->add('hash', null, array('label' => 'Hash'))
            ->add('configuration', null, array('label' => 'Configuration'));
    }

    /**
     * Конфигурация формы редактирования записи
     *
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text')
            ->add('password');

    }

    /**
     * Конфигурация списка записей
     *
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('text', null, array('label' => 'Text'))
            ->add('createDate', null, array('label' => 'Create Date'))
            ->add('endDate', null, array('label' => 'End Date'))
            ->add('password', null, array('label' => 'Password'))
            ->add('createdFromIp', null, array('label' => 'Created from IP'))
            ->add('viewsCount', null, array('label' => 'Views Count'))
            ->add('lastReviewFromIp', null, array('label' => 'Last Review From IP'))
            ->add('lastReviewDate', null, array('label' => 'Last Review Date'))
            ->add('email', null, array('label' => 'Send To Email'));
    }

    /**
     * Поля, по которым производится поиск в списке записей
     *
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('text', null, array('label' => 'Текст'));
    }
}