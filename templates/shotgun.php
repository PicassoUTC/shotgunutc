<div class="jumbotron">
<h1><?php echo $desc->titre; ?></h1>
<p class="lead"><?php echo $desc->desc; ?></p>
</div>

<div class="row marketing">
<div class="col-lg-12">

<?php
    if(!$username) {
        echo '<div class="alert alert-info">Avant toute chose tu dois te connecter ! <a class="btn btn-primary" href="login">Connexion</a></div>';
    } else if($desc->open_non_cotisant == 0 && $user->is_cotisant != 1) {
        echo '<div class="alert alert-info">Cet événement n\'est pas ouvert au non-cotisant. 
        Si tu veux prendre ta place, tu dois d\'abord aller cotiser 
        <a class="btn btn-primary" href="https://assos.utc.fr/bde/bdecotiz/">BDE COTIZ</a></div>';
    } else {
        $debut = new DateTime($desc->debut);
        $fin = new DateTime($desc->fin);
        $now = new DateTime("NOW");
        $diff = $now->diff($debut);
        if($diff->invert) {
            if($now->diff($fin)->invert) {
                echo "Vente terminé.";
            } else {
                ?>
                    <h2>Choisis ta place !</h2>
                    <?php print_r($user); ?>
                    <p>
                    Attention ! Il est possible qu'il apparaisse à un moment donné qu'il n'y a plus de place disponible puis que dans la minute d'après une place apparaisse.
                    C'est tout simplement lié au fait que des personnes peuvent sélectionner une place, puis finalement annuler au moment du paiement.
                    </p>
                    <table class="table">
                    <thead>
                        <th>Nom du choix</th>
                        <th>Prix</th>
                        <th></th>
                    </thead>
                    <?php foreach($desc->getChoices() as $choice) { ?>
                        <tr>
                            <td><?php echo $choice->name; ?></td>
                            <td><?php echo $choice->price/100; ?> €</td>
                            <td>
                            <?php if($choice->isAvailable()) { ?>
                                <a href="makeshotgun?id=<?php echo $desc->id; ?>&choice_id=<?php echo $choice->id; ?>" class="btn btn-primary">Shotgun !</a>
                            <?php } else { ?>
                                <a href="" class="btn btn-danger disabled">Complet !</a>
                            <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
            }
        } else {
            echo "Ouverture dans : ";
            echo '<div id="Countdown1"></div>';
            echo '<script> var c1 = '. (((($diff->d * 24 + $diff->h) * 60) + $diff->i) * 60 + $diff->s) . '; </script>';
        }


    }
?>



</div>
</div>