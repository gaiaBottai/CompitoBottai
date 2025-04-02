<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function view(Request $request,Response $response,$args){
    $id=$args['id'];
    $mysqli_connection=new MySQLi('my_mariadb','root','ciccio','scuola');
    $result=$mysqli_connection->query("SELECT * FROM alunni WHERE id='$id'");
    $results=$result->fetch_all(MYSQLI_ASSOC);
    if($results){
      $response->getBody()->write(json_encode($results));
    }else{
      $response->getBody()->write(json_encode("{'messaggio':'not found'}"));
    }
    return $response->withHeader("Content-type","application/json")->withStatus(200);
  }

  public function create(Request $request,Response $response,$args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body=json_decode($request->getBody()->getContents(), true);
    $nome=$body["nome"];
    $cognome=$body["cognome"];
    $result=$mysqli_connection->query("INSERT INTO alunni(nome,cognome) 
    VALUES ('$nome','$cognome')");
    if($result){
      $response->getBody()->write("{'status':'created'}");
    }
    else{
      $response->getBody()->write("{'status':'not found'}");
    }

    return $response->withHeader("Content-Type","application/json")->withStatus(201);

  }
  public function update(Request $request,Response $response, $args){
    $id=$args['id'];
    $mysqli_connection=new MySQLi('my_mariadb','root','ciccio','scuola');
    $body=json_decode($request->getBody()->getContents(), true);
    $nuovonome=$body["nome"];
    $nuovocognome=$body["cognome"];
    $query="UPDATE alunni SET nome='$nuovonome', cognome='$nuovocognome' WHERE id='$id'";
    $result=$mysqli_connection->query($query);
  
    if($result){
    $response->getBody()->write("{'status':'ok'}");

  } else{
    $response->getBody()->write("{'status':'404 not found'}");
  }
  return $response->withHeader("Content-Type","application/json")->withStatus(204);
  }
  public function destroy(Request $request, Response $response, $args){
    $id=$args['id'];
    $mysqli_connection=new MySQLi('my_mariadb', 'root','ciccio','scuola');
    $result=$mysqli_connection->query("DELETE from alunni WHERE id='$id'");
    if($result){
      $response->getBody()->write("{'status':'ok'}");
    }else{
      $response->getBody()->write("{'status':'404 not found'}");
    }
    return $response->withHeader("Content-type","application/json")->withStatus(204);
  
  }

}

