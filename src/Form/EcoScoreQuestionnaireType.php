<?php

// src/Form/EcoQuestionnaireType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EcoScoreQuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Exemple avec une seule question, répétez le processus pour les autres
            ->add('question1', ChoiceType::class, [
                'label' => 'Combien de repas contenant de la viande consommez-vous par semaine ?',
                'choices' => [
                    'Rarement ou jamais' => 3,
                    '1 à 3 fois' => 2,
                    '4 à 6 fois' => 1,
                    'Plus de 6 fois' => 0,
                ],
                'expanded' => true,

            ])
            
            ->add('question2', ChoiceType::class, [
                'label' => 'Achetez-vous des produits locaux ou issus de l\'agriculture biologique ?',
                'choices' => [
                    'Toujours' => 3,
                    'Souvent' => 2,
                    'Parfois' => 1,
                    'Jamais' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question3', ChoiceType::class, [
                'label' => 'Quelle quantité de déchets alimentaires jetez-vous par semaine ?',
                'choices' => [
                    'Aucun' => 3,
                    'Moins de 1 kg' => 2,
                    '1 à 2 kg' => 1,
                    'Plus de 2 kg' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question5', ChoiceType::class, [
                'label' => 'Quelle proportion de vos achats est composée de produits en vrac ou sans emballage plastique ?',
                'choices' => [
                    'La majorité ou tout' => 3,
                    'Environ la moitié' => 2,
                    'Quelques-uns' => 1,
                    'Aucun' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question6', ChoiceType::class, [
                'label' => 'Combien de fois avez-vous pris l\'avion au cours de la dernière année ?',
                'choices' => [
                    'Aucune' => 3,
                    '1 à 2 fois' => 2,
                    '3 à 5 fois' => 1,
                    'Plus de 5 fois' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question7', ChoiceType::class, [
                'label' => 'Quel est votre principal moyen de transport pour les déplacements quotidiens ?',
                'choices' => [
                    'Vélo, marche ou trottinette' => 3,
                    'Transports en commun' => 2,
                    'Voiture électrique ou hybride' => 1,
                    'Voiture essence/diesel' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question8', ChoiceType::class, [
                'label' => 'Votre logement est-il équipé d\'ampoules à faible consommation (LED, etc.) ?',
                'choices' => [
                    'Oui, partout' => 3,
                    'Majoritairement' => 2,
                    'Quelques-unes' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question9', ChoiceType::class, [
                'label' => 'Quelle est la fréquence de vos douches et quelle en est la durée moyenne ?',
                'choices' => [
                    'Moins de 5 minutes, peu fréquentes' => 3,
                    'Moins de 5 minutes, quotidiennes' => 2,
                    'Plus de 5 minutes, peu fréquentes' => 1,
                    'Plus de 5 minutes, quotidiennes' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question10', ChoiceType::class, [
                'label' => 'Utilisez-vous des appareils à haute efficacité énergétique (A+, A++) ?',
                'choices' => [
                    'Oui, pour tous mes appareils' => 3,
                    'Pour la majorité' => 2,
                    'Pour quelques-uns' => 1,
                    'Non, pour aucun' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question11', ChoiceType::class, [
                'label' => 'Triez-vous systématiquement vos déchets ?',
                'choices' => [
                    'Oui, toujours' => 3,
                    'La plupart du temps' => 2,
                    'Rarement' => 1,
                    'Jamais' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question12', ChoiceType::class, [
                'label' => 'Combien de fois par mois utilisez-vous des produits jetables (vaisselle, couverts, etc.) ?',
                'choices' => [
                    'Jamais' => 0,
                    'Moins de 3 fois' => 1,
                    '4 à 6 fois' => 2,
                    'Plus de 6 fois' => 3,
                ],
                'expanded' => true,
            ])
            ->add('question13', ChoiceType::class, [
                'label' => 'À quelle fréquence remplacez-vous vos appareils électroniques (téléphone, ordinateur, etc.) ?',
                'choices' => [
                    'Moins d\'une fois tous les 5 ans' => 3,
                    'Tous les 3 à 5 ans' => 2,
                    'Tous les 2 à 3 ans' => 1,
                    'Presque chaque année' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question14', ChoiceType::class, [
                'label' => 'Privilégiez-vous la réparation de vos appareils électroniques et électroménagers plutôt que leur remplacement ?',
                'choices' => [
                    'Toujours' => 3,
                    'Souvent' => 2,
                    'Rarement' => 1,
                    'Jamais' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question15', ChoiceType::class, [
                'label' => 'Participez-vous à des actions ou initiatives locales en faveur de l\'environnement (nettoyage de plages, reboisement, etc.) ?',
                'choices' => [
                    'Régulièrement' => 3,
                    'De temps en temps' => 2,
                    'Rarement' => 1,
                    'Jamais' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question15', ChoiceType::class, [
                'label' => 'Quelle quantité de produits neufs achetez-vous par rapport à des produits de seconde main ?',
                'choices' => [
                    'Principalement des produits de seconde main' => 3,
                    'Autant de neuf que de seconde main' => 2,
                    'Principalement des produits neufs' => 1,
                    'Uniquement des produits neufs' => 0,
                ],
                'expanded' => true,
            ])
            ->add('question15', ChoiceType::class, [
                'label' => 'Consommez-vous régulièrement des contenus numériques en streaming (vidéo, musique) ?',
                'choices' => [
                    'Rarement ou jamais' => 3,
                    'Quelques heures par semaine' => 2,
                    'Une heure par jour' => 1,
                    'Plusieurs heures par jour' => 0,
                ],
                'expanded' => true,
            ]);

            }

    }
