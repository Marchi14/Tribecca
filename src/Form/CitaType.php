<?php

namespace App\Form;

use App\Entity\Citas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitaType extends AbstractType
{
    public function servicios(){
        $serv = [];
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(Servicios::class);
        $p = $rep->findAll();
        for ($i=1;$i<sizeof($p);$i++){
            $find = $rep->find($p[$i]);
            $name = $find->getNombre();
            $serv[$name] = $i;
        }
        return $serv;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Fecha',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'required' => true,
                'attr' => ['onchange' => 'horario()']
            ])
            ->add('Hora',TimeType::class,[
                'hours' => range(9,20),
                'minutes' => range(0,30,30)
            ])
            ->add('Servicios',ChoiceType::class,[
                'choices' => $options['servicios'],
                'multiple' => true,
                'expanded' => true,
                'mapped' => false
            ])
            ->add('Descripcion',TextareaType::class)
            ->add('Concertar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
            'servicios' => false
        ]);

        $resolver->setAllowedTypes('servicios', 'array');
    }
}
