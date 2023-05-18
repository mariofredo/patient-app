<?php

header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Http\Response;

$loader = new Loader();
$loader->registerNamespaces(
    [
        'MyApp\Models' => __DIR__ . '/models/',
    ]
);
$loader->register();

$container = new FactoryDefault();
$container->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'zicare_db',
            ]
        );
    }
);

$app = new Micro($container);

$app->get('/api/patients', function() use ($app) {
  $phql = "SELECT * FROM MyApp\Models\Patients ORDER BY id ASC";
  $patients = $app -> modelsManager -> executeQuery($phql);
  $response = new Response();
  
  if($patients == false){
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 500,
          'response' => 'failed',
          'message' => 'Internal Server Error'
        ),
      )
    );
  }
  else {
    $data = array();
    foreach ($patients as $patient) {
      $data[] = array(
        'id' => $patient->id,
        'name' => $patient->name,
        'sex' => $patient->sex,
        'religion' => $patient->religion,
        'phone' => $patient->phone,
        'address' => $patient->address,
        'nik' => $patient->nik
      );
    }

    $response->setJsonContent(array(
      'status' => array(
        'code' => 200,
        'response' => "success",
        'message' => "success found patient with the requested id"
      ),
      'result' => $data
    ));
  }

  return $response;
});

$app->get('/api/patients/{id:[0-9]+}', function($id) use ($app) {
  $phql = "SELECT * FROM MyApp\Models\Patients WHERE id = :id:";
  $values = array('id'  =>  $id );
  $patient = $app -> modelsManager -> executeQuery($phql, $values)->getFirst();
  
  $response = new Response();

  if($patient == false)
  {
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 404,
          'response' => 'failed',
          'message' => 'failed found patient with the requested id'
        ),
      )
    );
  }
  else 
  {
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 200,
          'response' => "success",
          'message' => "success found patient with the requested id"
        ),
        'result' => [
          'id' => $patient->id,
          'name' => $patient->name,
          'sex' => $patient->sex,
          'religion' => $patient->religion,
          'phone' => $patient->phone,
          'address' => $patient->address,
          'nik' => $patient->nik
        ]
      )
    );
  }

  return $response;
});

$app->post('/api/patients', function() use ($app) {

  $patient = $app->request->getJsonRawBody();

  $phql = "INSERT INTO MyApp\Models\Patients (name, sex, religion, phone, address, nik) VALUES (:name:, :sex:, :religion:, :phone:, :address:, :nik:)";

  $values = array(
    'name' => $patient->name,
    'sex' => $patient->sex,
    'religion' => $patient->religion,
    'phone' => $patient->phone,
    'address' => $patient->address,
    'nik' => $patient->nik
  );

  $result = $app->modelsManager->executeQuery($phql, $values);
  $response = new Response();

  if($result->success() == TRUE)
  {
    $response->setStatusCode(201, 'Created');
    $patient = $result->getModel()->id;
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 201,
          'response' => "created",
          'message' => "success created patient data"
        ),
        'result' => $patient
      )
    );
  }
  else 
  {
    $errors = array();
    foreach ($result->getMessages() as $message ) {
      $errors[] = $message ->getMessage();
    };
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 409,
          'response' => 'Conflict',
          'message' => $errors
        ),
      )
    );
  }
  return $response;
});

$app->put('/api/patients/{id:[0-9]+}', function($id) use ($app) {
  $phql = "UPDATE MyApp\Models\Patients SET name = :name:, sex = :sex:, religion = :religion:, phone = :phone:, address = :address:, nik = :nik: WHERE id = :id:";

  $updatedPatientValues = $app->request->getJsonRawBody();
  $values = array(
    'id' => $id,
    'name' => $updatedPatientValues->name,
    'sex' => $updatedPatientValues->sex,
    'religion' => $updatedPatientValues->religion,
    'phone' => $updatedPatientValues->phone,
    'address' => $updatedPatientValues->address,
    'nik' => $updatedPatientValues->nik
  );

  $result = $app->modelsManager->executeQuery($phql, $values);

  $response = new Response();

  if($result->success() == TRUE)
  {
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 200,
          'response' => "success",
          'message' => "success updated patient data"
        ),
        'result'  => $result,
      )
    );
  }
  else 
  {
    $errors = array();
    foreach ($result->getMessages() as $message ) {
      $errors[] = $message ->getMessage();
    };
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 409,
          'response' => 'Conflict',
          'message' => $errors
        ),
      )
    );
  }
  return $response;
});

$app->delete('/api/patients/{id:[0-9]+}', function($id) use ($app){
  $phql = "DELETE FROM MyApp\Models\Patients WHERE id = :id:";

  $values = array(
    'id' => $id,
  );

  $result = $app->modelsManager->executeQuery($phql, $values);

  $response = new Response();

  if($result->success() == TRUE)
  {
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 200,
          'response' => "success",
          'message' => "success deleted patient data"
        ),
        "result" => $result
      )
    );
  }
  else 
  {
    $errors = array();
    foreach ($result->getMessages() as $message ) {
      $errors[] = $message ->getMessage();
    };
    $response->setJsonContent(
      array(
        'status' => array(
          'code' => 409,
          'response' => 'Conflict',
          'message' => $errors
        ),
      )
    );
  }
  return $response;
});

$app->options('/{catch:(.*)}', function() use ($app) { 
  $app->response->setStatusCode(200, "OK")->send();
});

$app->notFound(function() use ($app){
  $app->response->setStatusCode(404, "Not found")->sendHeaders();
  echo "The route you're looking not found";
});

$app->handle($_GET['_url'] ?? '/');