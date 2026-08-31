<?php
session_start(); 
include("conexao.php"); 
$id_usuario = $_POST['id_usuario'] ?? ''; 

if($id_usuario == ''){
     echo "0"; exit; 
     } 
     
     $sql = "SELECT COUNT(*) AS TOTAL FROM LIGACAO 
     WHERE (COD_USU = ? OR COD_USU_DESTINO = ?) AND STATUS_LIGACAO = 'ACEITA'"; 
      
      $stmt = $conexao->prepare($sql); 
      
      $stmt->bind_param( "ii", $id_usuario, $id_usuario ); 
      
      $stmt->execute(); 
      $resultado = $stmt->get_result(); 
      
      $linha = $resultado->fetch_assoc(); 
      
      echo $linha['TOTAL']; 
      
      $stmt->close(); 
      
      ?>