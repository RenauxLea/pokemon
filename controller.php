<form method="post"  action="controller.php">
            <h1>Chercher un pokemon </h1>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" placeholder="Bulbizarre">
                <input type="submit" value="recherche"   >
                   
</form>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pokemon";
    $name = $_POST["name"]; 
  
    
    if (!isset($name)){
      die("S'il vous plaît entrez un nom");
    }
   
    $bdd = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    
     
 
    $sql = "SELECT * FROM pokemon where name='{$name}'";
    $query = $bdd->prepare($sql );
    $query->execute(); 
    $resultat = $query->fetchAll(\PDO::FETCH_OBJ);
   
       
    if(empty($resultat)) {
        $response = file_get_contents('https://pokebuildapi.fr/api/v1/pokemon/'.$name);
        $data = json_decode($response);
       
        $sql2 = "INSERT INTO pokemon (name, image , id, apiGeneration) VALUES ('{$data->name}' , '{$data->image}', '{$data->id}' , '{$data->apiGeneration}')";
        $query2 = $bdd->prepare($sql2 );
        $query2->execute(); 

        $sql3= "SELECT * FROM pokemon WHERE name = '{$name}'";
        $query3 = $bdd->prepare($sql3);
        $query3->execute(); 

        $resultat =  $query3->fetchAll(\PDO::FETCH_OBJ);
    }

    echo "nom : " . $resultat[0]->name ." " ." id:  " .$resultat[0]->id . " generation: " . $resultat[0]->apiGeneration ;
    echo '<img src='.$resultat[0]->image.' >';

   

}


