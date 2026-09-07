<?php 
session_start(); 

include("conexao.php"); 

if(!isset($_SESSION['id_usuario'])){
     echo "0"; 
     exit; 
     } 
     
     $id_usuario = $_SESSION['id_usuario']; 
     
     $sql = "SELECT COUNT(*) AS TOTAL FROM LIGACAO 
     WHERE COD_USU_DESTINO = ? AND STATUS_LIGACAO = 'PENDENTE'"; 
     
     $stmt = $conexao->prepare($sql); 
     
     $stmt->bind_param("i", $id_usuario); 
     
     $stmt->execute(); 
     
     $resultado = $stmt->get_result(); 
     
     $row = $resultado->fetch_assoc(); 
     
     echo $row['TOTAL']; 
     
     $stmt->close(); 
     ?>