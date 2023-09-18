<?php

$users = $result['data']['users'];
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>

<div class="container-category">
    <div class="banner">

        <h1>Liste des utilisateurs</h1>

    </div>

    <table>
        <thead>
            <tr class="tr-table">
                <th>Pseudo</th>
                <th>Mail</th>
                <th>Date d'inscription</th>
                <th>Utilisateur bloqué</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($users as $user) {
                ?>
                    <td> <?= $user->getPseudo() ?></td>
                    <td><?= $user->getEmail() ?> </td>
                    <td><?= $user->getCreationDate() ?> </td>

                    <!-- bouton checkbox -->
                    <td class="td-checkbox">
                        <form class="form-checkbox" action="index.php?ctrl=security&action=closedUser&id=<?= $user->getId() ?>" method="post">

                            <input type="checkbox" name="isClosed" class="custom-checkbox <?= $user->getIsClosed() ? 'verrouille' : 'actif' ?>" id="custom-checkbox-<?= $user->getId() ?>">
                            <label for="custom-checkbox-<?= $user->getId() ?>" class="checkbox-label"> <?= $user->getIsClosed() ? "verrouillé" : "actif" ?> </label>

                            <input class="submit-checkbox" type="submit" name="submit" value="Modifier" style="display: none;">

                        </form>
                    </td>
            </tr>
                <?php
                } 
                ?>
        </tbody>
    </table>

</div>