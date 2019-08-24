<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class AddressBookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname',TextType::Class,array( 'required' => true, 'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('lastname',TextType::Class,array('required' => true,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('street_num',TextType::Class,array('required' => true,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('zip',TextType::Class,array('required' => true,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('city',TextType::Class,array('required' => true,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('country',TextType::Class,array('required' => true,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('phonenumber',TextType::Class,array('required' => false,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('birthday',DateType::Class,array('widget' => 'single_text','format' => 'yyyy-MM-dd','required' => false,'years' => range(date('Y'), date('Y')-100),'attr' =>  array('class' => 'formcontrol','style' => 'margin-bottom:10px;' ) ))
                ->add('emailaddress',EmailType::Class,array('required' => true,'attr' =>  array('class' => 'form-control','style' => 'margin-bottom:10px;') ))
                ->add('picture', FileType::class, array('label' => 'Picture (Optional)','data_class' => null,
                                                            'required' => false,
                                                            'constraints' => [
                                                                new File([
                                                                    'maxSize' => '1024k',
                                                                    'mimeTypes' => [
                                                                        'image/*',
                                                                    ],
                                                                    'mimeTypesMessage' => 'Please upload a valid Image File',
                                                                ])
                                                            ],
                                                        ))
            ->add('save',SubmitType::Class,array('attr' =>  array('class' => 'btn btn-primary','style' => 'margin-bottom:10px;') ));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AddressBook'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_addressbook';
    }


}
