<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dipend;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MartinaController extends AbstractController
{
    /**
     * @Route("/lucky/number/{max}", name="app_lucky_number")
     */
    public function number(int $max): Response
    {
        $number = random_int(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
    * @Route("/nuovo/dipendente/{nome}", name="app_nuovo_dipendente")
    */

    public function creaDipendenti(ManagerRegistry $doctrine, string $nome) : Response
    {
        //$doctrine = new ManagerRegistry();
        $entityManager = $doctrine->getManager();

        $dipendente = new Dipend();
        $dipendente->setName($nome);
        $dipendente->setEmail($nome.'@gmail.test');

        $entityManager->persist($dipendente);
        $entityManager->flush();

        return new Response('Nuovo dipendente inserito, ID: '.$dipendente->getId());
    }

    
    /**
    * @Route("/mostra/dipendente/{id}", name="app_mostra_dipendente")
    */

    public function show(ManagerRegistry $doctrine, int $id): Response
    {
            
        $dipendente = $doctrine->getRepository(Dipendenti::class)->find($id);

        if (!$dipendente) {
            throw $this->createNotFoundException(
                'Nessun dipendente con ID '.$id
            );
        }

        //return new Response('Ecco qui ' . $dipendente->getNome());

         // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('dipendente/show.html.twig', ['bicchiere' => $dipendente]);
   
    }
}
