<?php 
 
    ?><form method="post"  action="controller.php">
            <h1>Chercher un pokemon </h1>        
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" placeholder="Bulbizarre">
              
                <input type="submit" value="recherche"   >
                   
        </form>

<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pokemon";   
   
    $bdd = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

    $sql = "SELECT * FROM pokemon where apiGeneration = 2 ";
    $query = $bdd->prepare($sql );
    $query->execute(); 
    $resultat = $query->fetchAll(\PDO::FETCH_OBJ);
   
    if(empty($resultat)) {      
       echo "il n'y a pas de pokemon";
    }

    if(!empty($resultat)) {
        foreach ($resultat as $result){
            
            ?> <div> 
            <?php
            echo "nom :" . $result->name ." " ." id: " .$result->id;
            echo '<img src='.$result->image.' >';
           ?>
               </div>
               <?php
        }

     }


