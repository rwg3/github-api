<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {      
        $client = new \Github\Client();
        $response = $client->getHttpClient()->get('repos/symfony/symfony/stats/participation');
        $participation = \Github\HttpClient\Message\ResponseMediator::getContent($response);
        
        return $this->render('default/index.html.twig', [
            'participation' => $participation
        ]);
    }
    /**
     * @Route("/branches", name="branches")
     */
    public function branchesShowAction(Request $request)
    {
        $client = new \Github\Client();        
        $branches = $client->api('repo')->branches('symfony', 'symfony');
        
        return $this->render('branches.html.twig', [
            'branches' => $branches
        ]);
    }
    /**
     * @Route("/commits", name="commits")
     */
    public function commitsShowAction(Request $request)
    {
        
        $client = new \Github\Client();        
        $commits = $client->api('repo')->commits()->all('symfony', 'symfony', array('sha' => 'master'));
        
        return $this->render('commits.html.twig', [
            'commits' => $commits
        ]);
    }
    /**
     * @Route("/contributors", name="contributors")
     */
    public function contributorsShowAction(Request $request)
    {
        $client = new \Github\Client();        
        $response = $client->getHttpClient()->get('repos/symfony/symfony/contributors');
        $contributors = \Github\HttpClient\Message\ResponseMediator::getContent($response);
        
        return $this->render('contributors.html.twig', [
            'contributors' => $contributors
        ]);
    }
}
