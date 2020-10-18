<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
error_reporting(0);

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
    // API Konsultasi berdasarkan id user
   $app->get("/konsultasi/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM tbl_konsultasi WHERE id_user=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});
   // API konsultasi ambil semua data
   $app->get("/konsultasi/",function(Request $request, Response $response){
   	$sql = "SELECT * FROM tbl_konsultasi";
   	$stmt = $this->db->prepare($sql);
   	$stmt->execute();
   	$result=$stmt->fetchAll();
   	return $response->withJson(["status" => "success","data"=>$result], 200);
   });

   // Get doctor dll
    $app->get("/doctor/",function(Request $request, Response $response){
   	$sql = "SELECT * FROM tbl_user";
   	$stmt = $this->db->prepare($sql);
   	$stmt->execute();
   	$result=$stmt->fetchAll();
   	return $response->withJson(["status" => "success","data"=>$result], 200);
   });

    // API Add Iklan
   $app->post("/iklan/", function (Request $request, Response $response){ 
	$emp = json_decode($request->getBody()); 

    $sql = "INSERT INTO tbl_iklan(nama_iklan,harga_iklan,foto_iklan,tgl_beli_iklan,id_clinic,expired_iklan,total_iklan,sisa_iklan,used_iklan ) VALUE (:nama_iklan,:harga_iklan,:foto_iklan,:tgl_beli_iklan,:id_clinic,:expired_iklan,:total_iklan,:sisa_iklan,:used_iklan)";
   $stmt = $this->db->prepare($sql);
	$data = [
	
		":nama_iklan" => $emp->nama_iklan,
		":harga_iklan" => $emp->harga_iklan,
		":foto_iklan" => $emp->foto_iklan,
		":tgl_beli_iklan" => $emp->tgl_beli_iklan,
		":id_clinic" => $emp->id_clinic,
		":expired_iklan" => $emp->expired_iklan,
		":total_iklan" => $emp->total_iklan,
		":sisa_iklan" => $emp->sisa_iklan,
		":used_iklan" => $emp->used_iklan
];
if($stmt->execute($data))
return $response->withJson(["status" => "success", "data" => "1"], 200);

return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

    // API Add Push Notif
   

};
