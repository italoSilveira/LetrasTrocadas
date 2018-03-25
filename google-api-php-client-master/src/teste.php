<?php
  require_once 'Google/Client.php'; //incluindo o cliente da API
  require_once 'Google/Service/Books.php'; //incluindo o serviço do Books
  $client = new Google_Client(); //instanciando o cliente
  $client->setApplicationName("LetrasTrocadas"); //nome da aplicação criada através da API
  $client->setDeveloperKey("AIzaSyDxQSLHoLk90te8pnh3cBSG9jRvleGV9UI"); //código da aplicação criada através da API
  $service = new Google_Service_Books($client); //instanciando o serviço do Books
  $optParams = array('filter' => 'free-ebooks'); //filtrando apenas livros gratuitos
  $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams); //busca
  
  foreach ($results as $item) {
    echo $item['volumeInfo']['title'], "<br /> \n"; //exibindo informações dos volumes (título)
  }
