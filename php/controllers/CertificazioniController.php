<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController{
    public function index(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $result = $mysqli_connection->query("SELECT * FROM certificazioni");
        $results = $result->fetch_all(MYSQLI_ASSOC);
    
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
    public function view(Request $request, Response $response, $args){
        $id=$args['id'];
        $mysqli_connection=new MySQLi('my_mariadb','root','ciccio', 'scuola');//connessione
        $result=$mysqli_connection->query("SELECT * FROM certificazioni WHERE id='$id'");//select per visualizzare ciò che viene richiesto
        $results=$result->fetch_all(MYSQLI_ASSOC);
        if($results){
          $response->getBody()->write(json_encode($results));//stampa se è avvenuto con successo
          
        } else{
          $response->getBody()->write(json_encode("{'messaggio':'notfound'}"));
        }
        return $response->withHeader("Content-type","application/json")->withStatus(200);
      }

      public function create(Request $request,Response $response,$args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $body=json_decode($request->getBody()->getContents(), true);
        $alunno=$body["alunno_id"];
        $titolo=$body["titolo"];
        $votazione=$body["votazione"];
        $ente=$body["ente"];
        $result=$mysqli_connection->query("INSERT INTO certificazioni(alunno_id,titolo,votazione,ente) 
        VALUES ('$alunno','$titolo','$votazione','$ente')");
        if($result){
          $response->getBody()->write("{'status':'created'}");
        }
        else{
          $response->getBody()->write("{'status':'error'}");
        }
    
        return $response->withHeader("Content-Type","application/json")->withStatus(201);
    
      }
      public function update(Request $request,Response $response, $args){
        $id=$args['id'];
        $mysqli_connection=new MySQLi('my_mariadb','root','ciccio','scuola');
        $body=json_decode($request->getBody()->getContents(), true);
        $nuovotitolo=$body["titolo"];
        $nuovavotazione=$body["votazione"];
        $nuovoente=$body["ente"];
        $query="UPDATE certificazioni SET titolo='$nuovotitolo', votazione='$nuovavotazione', ente='$nuovoente' WHERE id='$id'";
        $result=$mysqli_connection->query($query);
      
        if($result){
        $response->getBody()->write("{'status':'ok'}");
    
      } else{
        $response->getBody()->write("{'status':'404 not found'}");
      }
      return $response->withHeader("Content-Type","application/json")->withStatus(201);
      }

      public function destroy(Request $request, Response $response, $args){
        $id=$args['id'];
        $mysqli_connection=new MySQLi('my_mariadb', 'root','ciccio','scuola');
        $result=$mysqli_connection->query("DELETE from certificazioni WHERE id='$id'");
        if($result){
          $response->getBody()->write("{'status':'ok'}");
        }else{
          $response->getBody()->write("{'status':'404 not found'}");
        }
        return $response->withHeader("Content-type","application/json")->withStatus(204);
      
      }
}
?>