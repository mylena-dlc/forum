<?php

$user = $result['data']['user'];
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>

<div class="container-category">
    <div class="banner">

        <h1>Mon profil</h1>

    </div>

    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Mail</th>
                <th>Date d'inscription</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> <?= $user->getPseudo() ?></td>
                <td><?= $user->getEmail() ?> </td>
                <td><?= $user->getCreationDate() ?> </td>
            </tr>

        </tbody>

    </table>

    <div class="update-profile">

        <div class="update-pseudo">
            <h4>Modifier mon pseudo</h4>
            <form action="index.php?ctrl=security&action=updatePseudo&id=<?= $user->getId() ?>" method="post">

                <label for="pseudo">Nouveau pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="<?= $user->getPseudo() ?>" required>

                <input class="submit-topic submit-category" type="submit" name="submit" value="Modifier">

            </form>
        </div>

        <div class="update-email">
            <h4>Modifier mon email</h4>

            <form action="index.php?ctrl=security&action=updateEmail&id=<?= $user->getId() ?>" method="post">

                <label for="email">Nouveau mail :</label>
                <input type="email" id="email" name="email" placeholder="<?= $user->getEmail() ?>" required>

                <input class="submit-topic submit-category" type="submit" name="submit" value="Modifier">

            </form>
        </div>

        <div class="update-password">
            <h4>Modifier mon mot de passe</h4>
            <form action="index.php?ctrl=security&action=updatePassword&id=<?= $user->getId() ?>" method="post">

                <label for="password">Ancien mot de passe :</label>
                <div class="password-input-container">
                    <input class="input-password" type="password" id="password-input" name="password" placeholder="Entrez votre mot de passe" minlength="12" required>
                    <p id="password-p"><i class="fa-solid fa-eye" id="show-password"></i> Afficher votre mot de passe</p>
                </div>

                <label for="newPassword">Nouveau mot de passe :</label>
                <div class="password-input-container">
                    <input class="input-password" type="password" id="password-input" name="newPassword" placeholder="Entrez votre nouveau mot de passe" minlength="12" required>
                    <p id="password-p"><i class="fa-solid fa-eye" id="show-password"></i> Afficher votre mot de passe</p>
                </div>

                <label for="confirmNewPassword">Confirmez le nouveau mot de passe :</label>
                <div class="password-input-container">
                    <input class="input-password" type="password" id="password-input" name="confirmNewPassword" placeholder="Confirmez votre nouveau mot de passe" minlength="12" required>
                    <p id="password-p"><i class="fa-solid fa-eye" id="show-password"></i> Afficher votre mot de passe</p>
                </div>

                <input class="submit-topic submit-category" type="submit" name="submit" value="Modifier">

            </form>
        </div>

    </div>

</div>