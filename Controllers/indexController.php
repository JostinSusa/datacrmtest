<?php 

class indexController{
  
  public function indexAction() { // DEFAULT_FUNCTION
    
    require_once('Views/index/index.php');
  }


  public function showinfoAction(){

    // === PASO 1 ==================== getchallenge

    // Definición de variables

    $operation = 'getchallenge';
    $user = 'prueba';

    //Iniciamos y ejecutamos CURL
    $challenge = curl_init();

    curl_setopt($challenge, CURLOPT_URL, "https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php?operation=".$operation."&username=".$user);
    curl_setopt($challenge, CURLOPT_RETURNTRANSFER, true);

    //Guardamos la respuesta decodificada en una variable como objeto
    $response_challenge = json_decode(curl_exec($challenge));

    //Cerramos la conexion
    curl_close($challenge);


    // === PASO 2 ==================== login

    //Definición de variables

    $operation = 'login';

    // Se genera la clave con md5 y concatenando una cadena de caracteres
    $accessKey = md5($response_challenge->result->token.'Vn4HOWtkJOsPX7t');

    $login = curl_init();
    curl_setopt($login, CURLOPT_URL, 'https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php');
    curl_setopt($login, CURLOPT_HEADER, 'Content-Type: application/x-www-form-urlencoded');
    curl_setopt($login, CURLOPT_POST, 1);
    curl_setopt($login, CURLOPT_POSTFIELDS, "operation=".$operation."&username=".$user."&accessKey=".$accessKey);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, true);
    $response_login = json_decode(curl_exec($login));
    curl_close($login);


    // === PASO 3 ==================== query

    //Definición de variables

    $operation = 'query';
    $sessionName = $response_login->result->sessionName;
    $query_text = 'select * from Contacts;';
    $query = curl_init();
    curl_setopt($query, CURLOPT_URL, 'https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php?operation='.$operation.'&sessionName='.urlencode($sessionName).'&query='.urlencode($query_text));
    curl_setopt($query, CURLOPT_RETURNTRANSFER, true);
    $response_query = json_decode(curl_exec($query));
    curl_close($query);

    // === Se procesa la información para responder la petición con una tabla html

    $response = '';

    $response .= '
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>contact_no</th>
            <th>lastname</th>
            <th>createdtime</th>
          </tr>
        </thead>
        <tbody>
    ';

    foreach ($response_query->result as $row) {
      $response .= '
        <tr>
          <td>'.$row->id.'</td>
          <td>'.$row->contact_no.'</td>
          <td>'.$row->lastname.'</td>
          <td>'.$row->createdtime.'</td>
        </tr>
        ';
    }

    $response .= '
      </tbody>
    </table>
    ';

    // Respuesta de la petición

    echo $response;

  }
}