<?php 
namespace App\Controllers;

use App\Models\CorporationModel;

class DirController extends Controller {

    public function __construct($templateEngine) {
        $this->model = new CorporationModel();
        $this->templateEngine = $templateEngine;
    }

    public function welcomePage() {
        echo $this->templateEngine->render('home.html.twig');
    }    


    public function offerPage() {
        echo $this->templateEngine->render('offres.html.twig');
    }

    public function uploadPage() {

    }
}
