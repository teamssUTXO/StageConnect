<?php
namespace App\Controllers;

class DirController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function WelcomePage()
    {
        echo $this->twig->render('home.html.twig', [
            'title' => 'Accueil',
        ]);
    }

    public function OffersPage()
{
    echo $this->twig->render('search-offer.html.twig', [
        'title' => 'Rechercher des offres de stage',
    ]);
}

    public function CompaniesPage()
    {
        echo $this->twig->render('search-company.html.twig', [
            'title' => 'Rechercher des entreprises',
        ]);
    }

    public function AboutPage()
    {
        echo $this->twig->render('about.html.twig', [
            'title' => 'À propos',
        ]);
    }

    public function ContactPage()
    {
        echo $this->twig->render('contact.html.twig', [
            'title' => 'Contact',
        ]);
    }

    public function LoginPage()
    {
        echo $this->twig->render('login.html.twig', [
            'title' => 'Connexion',
        ]);
    }
}